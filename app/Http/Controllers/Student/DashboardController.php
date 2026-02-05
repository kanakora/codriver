<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $publishedCount = Content::query()->published()->count();
        $categoryCount = Category::query()->count();
        $latestContents = Content::query()
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
            'latestContents' => $latestContents,
        ]);
    }
}
