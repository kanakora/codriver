<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentStoreRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Models\Content;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Content::class);

        $view = $request->routeIs('student.*')
            ? 'Student/Contents/Index'
            : 'Admin/Contents/Index';

        $query = Content::with(['author', 'categories'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->input('category'), function ($query, $categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            });

        if (! $request->user()?->can('manage content')) {
            $query->published();
        } else {
            $query->when($request->input('status'), function ($query, $status) {
                switch ($status) {
                    case 'draft':
                        $query->draft();
                        break;
                    case 'scheduled':
                        $query->scheduled();
                        break;
                    case 'active':
                        $query->active();
                        break;
                    case 'expired':
                        $query->expired();
                        break;
                    case 'archived':
                        $query->archived();
                        break;
                }
            });
        }

        $contents = $query->latest()->paginate(10)->withQueryString();

        $categories = Category::all();

        return Inertia::render($view, [
            'contents' => $contents,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Content::class);

        $categories = Category::all();

        return Inertia::render('Admin/Contents/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Content::class);

        $validated = $request->validated();
        $validated = $this->applyScheduling($validated);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('content_files', 'public');
        }

        $content = new Content($validated);
        $content->author_id = auth('web')->id();
        $content->shouldRecordRevision = false;
        $content->save();

        if (! empty($validated['category_ids'])) {
            $content->categories()->sync($validated['category_ids']);
        }

        $content->shouldRecordRevision = true;
        $content->recordRevision();

        return redirect()->route('admin.contents.index')->with('success', 'Content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content): Response
    {
        $this->authorize('view', $content);

        $view = request()->routeIs('student.*')
            ? 'Student/Contents/Show'
            : 'Admin/Contents/Show';

        $content->load(['author', 'categories']);
        $revisions = [];

        if (request()->routeIs('admin.*')) {
            $revisions = $content->revisions()
                ->with('user')
                ->latest()
                ->take(config('content.revisions.limit', 25))
                ->get();
        }

        return Inertia::render($view, [
            'content' => $content,
            'revisions' => $revisions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content): Response
    {
        $this->authorize('update', $content);

        $categories = Category::all();
        $content->load('categories');

        return Inertia::render('Admin/Contents/Edit', [
            'content' => $content,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentUpdateRequest $request, Content $content): RedirectResponse
    {
        $this->authorize('update', $content);

        $validated = $request->validated();
        $validated = $this->applyScheduling($validated, $content);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('content_files', 'public');
        }

        $content->shouldRecordRevision = false;
        $content->fill($validated);
        $content->save();

        $content->categories()->sync($validated['category_ids'] ?? []);

        $content->shouldRecordRevision = true;
        $content->recordRevision();

        return redirect()->route('admin.contents.index')->with('success', 'Content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content): RedirectResponse
    {
        $this->authorize('delete', $content);

        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Content deleted successfully.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function applyScheduling(array $validated, ?Content $content = null): array
    {
        foreach (['scheduled_publish_at', 'expires_at', 'archived_at'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $now = now();
        $scheduledAt = isset($validated['scheduled_publish_at'])
            ? Carbon::parse($validated['scheduled_publish_at'])
            : null;
        $expiresAt = isset($validated['expires_at'])
            ? Carbon::parse($validated['expires_at'])
            : null;

        if ($scheduledAt && $scheduledAt->isFuture()) {
            $validated['publish_status'] = 'draft';
            $validated['published_at'] = null;
        } elseif (($validated['publish_status'] ?? null) === 'published') {
            $validated['published_at'] = $content?->published_at ?? $now;
        } else {
            $validated['published_at'] = null;
        }

        if ($scheduledAt && $scheduledAt->lessThanOrEqualTo($now) && ($validated['publish_status'] ?? null) === 'draft') {
            $validated['publish_status'] = 'published';
            $validated['published_at'] = $content?->published_at ?? $now;
        }

        if ($expiresAt && $expiresAt->lessThanOrEqualTo($now)) {
            $validated['archived_at'] = $validated['archived_at'] ?? $now;
        }

        return $validated;
    }
}
