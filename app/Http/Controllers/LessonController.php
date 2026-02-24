<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Lesson::class);

        $view = $request->routeIs('student.*')
            ? 'Student/Lessons/Index'
            : 'Admin/Lessons/Index';

        $query = Lesson::with(['author', 'categories'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->input('category'), function ($query, $categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            });

        if (! $request->user()?->can('manage lessons')) {
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

        $lessons = $query->latest()->paginate(10)->withQueryString();

        $categories = Category::all();

        return Inertia::render($view, [
            'lessons' => $lessons,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Lesson::class);

        $categories = Category::all();

        return Inertia::render('Admin/Lessons/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Lesson::class);

        $validated = $request->validated();
        $validated = $this->applyScheduling($validated);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('content_files', 'public');
        }

        $lesson = new Lesson($validated);
        $lesson->author_id = auth('web')->id();
        $lesson->shouldRecordRevision = false;
        $lesson->save();

        if (! empty($validated['category_ids'])) {
            $lesson->categories()->sync($validated['category_ids']);
        }

        $lesson->shouldRecordRevision = true;
        $lesson->recordRevision();

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson): Response
    {
        $this->authorize('view', $lesson);

        $view = request()->routeIs('student.*')
            ? 'Student/Lessons/Show'
            : 'Admin/Lessons/Show';

        $lesson->load(['author', 'categories']);
        $revisions = [];

        if (request()->routeIs('admin.*')) {
            $revisions = $lesson->revisions()
                ->with('user')
                ->latest()
                ->take(config('content.revisions.limit', 25))
                ->get();
        }

        return Inertia::render($view, [
            'lesson' => $lesson,
            'revisions' => $revisions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson): Response
    {
        $this->authorize('update', $lesson);

        $categories = Category::all();
        $lesson->load('categories');

        return Inertia::render('Admin/Lessons/Edit', [
            'lesson' => $lesson,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson): RedirectResponse
    {
        $this->authorize('update', $lesson);

        $validated = $request->validated();
        $validated = $this->applyScheduling($validated, $lesson);

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('content_files', 'public');
        }

        $lesson->shouldRecordRevision = false;
        $lesson->fill($validated);
        $lesson->save();

        $lesson->categories()->sync($validated['category_ids'] ?? []);

        $lesson->shouldRecordRevision = true;
        $lesson->recordRevision();

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson): RedirectResponse
    {
        $this->authorize('delete', $lesson);

        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function applyScheduling(array $validated, ?Lesson $lesson = null): array
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
            $validated['published_at'] = $lesson?->published_at ?? $now;
        } else {
            $validated['published_at'] = null;
        }

        if ($scheduledAt && $scheduledAt->lessThanOrEqualTo($now) && ($validated['publish_status'] ?? null) === 'draft') {
            $validated['publish_status'] = 'published';
            $validated['published_at'] = $lesson?->published_at ?? $now;
        }

        if ($expiresAt && $expiresAt->lessThanOrEqualTo($now)) {
            $validated['archived_at'] = $validated['archived_at'] ?? $now;
        }

        return $validated;
    }
}
