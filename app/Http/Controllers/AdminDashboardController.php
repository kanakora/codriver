<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        $totalContents = Content::query()->count();
        $publishedContents = Content::query()->published()->count();
        $draftContents = Content::query()->draft()->count();
        $categoryCount = Category::query()->count();

        $recentContents = Content::query()
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
                'totalContents' => $totalContents,
                'publishedContents' => $publishedContents,
                'draftContents' => $draftContents,
                'categoryCount' => $categoryCount,
            ],
            'recentContents' => $recentContents,
        ]);
    }
}
