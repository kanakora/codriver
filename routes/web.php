<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContentRevisionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function (Request $request) {
    $user = $request->user();

    if ($user?->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }

    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes - content and category management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index', 'update']);
    Route::resource('roles', RoleController::class)->only(['index', 'store']);
    Route::resource('contents', ContentController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('collections', CollectionController::class);
    Route::post('contents/{content}/revisions/{revision}/restore', [ContentRevisionController::class, 'restore'])
        ->name('contents.revisions.restore');
});

// Student routes - view published content
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('contents', [ContentController::class, 'index'])->name('contents.index');
    Route::get('contents/{content}', [ContentController::class, 'show'])->name('contents.show');
    Route::get('collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
});

require __DIR__.'/settings.php';
