<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRoleUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::query()
            ->with('roles')
            ->latest()
            ->paginate(10);

        $roles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function update(UserRoleUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->syncRoles($validated['roles'] ?? []);

        return back()->with('success', 'User roles updated successfully.');
    }
}
