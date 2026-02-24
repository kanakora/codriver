<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lesson;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        $totalLessons = Lesson::query()->count();
        $publishedLessons = Lesson::query()->published()->count();
        $draftLessons = Lesson::query()->draft()->count();
        $categoryCount = Category::query()->count();

        $recentLessons = Lesson::query()
            ->latest()
            ->take(6)
            ->get([
                'id',
                'title',
                'publish_status',
                'created_at',
                'published_at',
            ]);

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalLessons' => $totalLessons,
                'publishedLessons' => $publishedLessons,
                'draftLessons' => $draftLessons,
                'categoryCount' => $categoryCount,
            ],
            'recentLessons' => $recentLessons,
        ]);
    }
}
