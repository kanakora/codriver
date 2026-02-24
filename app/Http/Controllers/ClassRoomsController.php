<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRoomStoreRequest;
use App\Http\Requests\ClassRoomUpdateRequest;
use App\Models\ClassRoom;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClassRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', ClassRoom::class);

        $view = $request->routeIs('student.*')
            ? 'Student/ClassRooms/Index'
            : 'Admin/ClassRooms/Index';

        $query = ClassRoom::query()
            ->with(['prerequisite'])
            ->withCount('contents')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });

        if (! $request->user()?->can('manage classrooms')) {
            $query->public();
        }

        $classrooms = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render($view, [
            'classrooms' => $classrooms,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', ClassRoom::class);

        return Inertia::render('Admin/ClassRooms/Create', [
            'lessons' => Lesson::query()
                ->with('categories')
                ->latest()
                ->get(),
            'classes' => ClassRoom::query()->orderBy('title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRoomStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ClassRoom::class);

        $validated = $request->validated();

        $classroom = ClassRoom::create($validated);

        $this->syncLessons($classroom, $validated['content_ids'] ?? []);

        return redirect()
            ->route('admin.classrooms.index')
            ->with('success', 'Classroom created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ClassRoom $classroom): Response
    {
        $this->authorize('view', $classroom);

        $view = $request->routeIs('student.*')
            ? 'Student/ClassRooms/Show'
            : 'Admin/ClassRooms/Show';

        if ($request->routeIs('student.*')) {
            $classroom->load([
                'prerequisite',
                'contents' => fn ($query) => $query->with('categories')->published(),
            ]);
        } else {
            $classroom->load(['prerequisite', 'contents.categories']);
        }

        return Inertia::render($view, [
            'classroom' => $classroom,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $classroom): Response
    {
        $this->authorize('update', $classroom);

        $classroom->load('contents');

        return Inertia::render('Admin/ClassRooms/Edit', [
            'classroom' => $classroom,
            'contents' => Lesson::query()
                ->with('categories')
                ->latest()
                ->get(),
            'classrooms' => ClassRoom::query()
                ->whereKeyNot($classroom->getKey())
                ->orderBy('title')
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassRoomUpdateRequest $request, ClassRoom $classroom): RedirectResponse
    {
        $this->authorize('update', $classroom);

        $validated = $request->validated();

        $classroom->update($validated);

        $this->syncLessons($classroom, $validated['content_ids'] ?? []);

        return redirect()
            ->route('admin.classrooms.index')
            ->with('success', 'ClassRoom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classroom): RedirectResponse
    {
        $this->authorize('delete', $classroom);

        $classroom->delete();

        return redirect()
            ->route('admin.classrooms.index')
            ->with('success', 'ClassRoom deleted successfully.');
    }

    /**
     * @param  array<int, int>  $contentIds
     */
    private function syncLessons(ClassRoom $classroom, array $contentIds): void
    {
        $syncData = [];

        foreach ($contentIds as $index => $contentId) {
            $syncData[$contentId] = ['sort_order' => $index + 1];
        }

        $classroom->lessons()->sync($syncData);
    }
}
