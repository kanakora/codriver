<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Models\Collection;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Collection::class);

        $view = $request->routeIs('student.*')
            ? 'Student/Collections/Index'
            : 'Admin/Collections/Index';

        $query = Collection::query()
            ->with(['prerequisite'])
            ->withCount('contents')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });

        if (! $request->user()?->can('manage collections')) {
            $query->public();
        }

        $collections = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render($view, [
            'collections' => $collections,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Collection::class);

        return Inertia::render('Admin/Collections/Create', [
            'contents' => Content::query()
                ->with('categories')
                ->latest()
                ->get(),
            'collections' => Collection::query()->orderBy('title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CollectionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Collection::class);

        $validated = $request->validated();

        $collection = Collection::create($validated);

        $this->syncContents($collection, $validated['content_ids'] ?? []);

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Collection $collection): Response
    {
        $this->authorize('view', $collection);

        $view = $request->routeIs('student.*')
            ? 'Student/Collections/Show'
            : 'Admin/Collections/Show';

        if ($request->routeIs('student.*')) {
            $collection->load([
                'prerequisite',
                'contents' => fn ($query) => $query->with('categories')->published(),
            ]);
        } else {
            $collection->load(['prerequisite', 'contents.categories']);
        }

        return Inertia::render($view, [
            'collection' => $collection,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection): Response
    {
        $this->authorize('update', $collection);

        $collection->load('contents');

        return Inertia::render('Admin/Collections/Edit', [
            'collection' => $collection,
            'contents' => Content::query()
                ->with('categories')
                ->latest()
                ->get(),
            'collections' => Collection::query()
                ->whereKeyNot($collection->getKey())
                ->orderBy('title')
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CollectionUpdateRequest $request, Collection $collection): RedirectResponse
    {
        $this->authorize('update', $collection);

        $validated = $request->validated();

        $collection->update($validated);

        $this->syncContents($collection, $validated['content_ids'] ?? []);

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection): RedirectResponse
    {
        $this->authorize('delete', $collection);

        $collection->delete();

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully.');
    }

    /**
     * @param  array<int, int>  $contentIds
     */
    private function syncContents(Collection $collection, array $contentIds): void
    {
        $syncData = [];

        foreach ($contentIds as $index => $contentId) {
            $syncData[$contentId] = ['sort_order' => $index + 1];
        }

        $collection->contents()->sync($syncData);
    }
}
