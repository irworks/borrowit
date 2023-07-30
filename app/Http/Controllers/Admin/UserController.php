<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $roles = [
            UserRole::User->value => __('auth.roles-' . UserRole::User->value),
            UserRole::Manager->value => __('auth.roles-' . UserRole::Manager->value),
            UserRole::Admin->value => __('auth.roles-' . UserRole::Admin->value),
        ];

        return view('users.index', ['users' => User::all(), 'roles' => $roles]);
    }
}