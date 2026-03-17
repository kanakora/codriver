<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassRoomsController;
use App\Http\Controllers\ContentRevisionController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LessonsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

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
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    // Role management
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');

    // Lessons management
    Route::get('lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('lessons/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    // Content revisions
    Route::post('lessons/{lesson}/upload', [ContentRevisionController::class, 'upload'])->name('lessons.upload');
    Route::post('lessons/{lesson}/revisions/{revision}/restore', [ContentRevisionController::class, 'restore'])->name('lessons.revisions.restore');

    // Categories management
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Classrooms management
    Route::get('classrooms', [ClassRoomsController::class, 'index'])->name('classrooms.index');
    Route::get('classrooms/create', [ClassRoomsController::class, 'create'])->name('classrooms.create');
    Route::post('classrooms', [ClassRoomsController::class, 'store'])->name('classrooms.store');
    Route::get('classrooms/{classroom}', [ClassRoomsController::class, 'show'])->name('classrooms.show');
    Route::get('classrooms/{classroom}/edit', [ClassRoomsController::class, 'edit'])->name('classrooms.edit');
    Route::put('classrooms/{classroom}', [ClassRoomsController::class, 'update'])->name('classrooms.update');
    Route::delete('classrooms/{classroom}', [ClassRoomsController::class, 'destroy'])->name('classrooms.destroy');
});

// Student routes - view published content
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Classrooms - view only
    Route::get('classrooms', [ClassRoomsController::class, 'index'])->name('classrooms.index');
    Route::get('classrooms/{classroom}', [ClassRoomsController::class, 'show'])->name('classrooms.show');

    Route::prefix('classrooms/{classroom}')->group(function () {
        // Lessons - view only
        Route::get('lessons', [LessonsController::class, 'index'])->name('lessons.index');
        Route::get('lessons/{lesson:slug}', [LessonsController::class, 'show'])->name('lessons.show');
    });
});

require __DIR__.'/settings.php';
