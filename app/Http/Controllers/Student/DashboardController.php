<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lesson;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $publishedCount = Lesson::query()->published()->count();
        $categoryCount = Category::query()->count();
        $latestLessons = Lesson::query()
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get([
                'id',
                'title',
                'content_type',
                'published_at',
            ]);

        return Inertia::render('Student/Dashboard', [
            'stats' => [
                'publishedCount' => $publishedCount,
                'categoryCount' => $categoryCount,
            ],
            'latestLessons' => $latestLessons,
        ]);
    }
}
