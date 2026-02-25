<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClassRoom;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Lesson::class);

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

        $lessons = $query->latest()->paginate(10)->withQueryString();

        $categories = Category::all();

        return Inertia::render('Student/Lessons/Index', [
            'lessons' => $lessons,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classroom, Lesson $lesson): Response
    {
        $this->authorize('view', $lesson);

        $lesson->load(['author', 'categories']);
        $revisions = [];

        return Inertia::render('Student/Lessons/Show', [
            'classroom' => $classroom,
            'lesson' => $lesson,
            'revisions' => $revisions,
        ]);
    }
}
