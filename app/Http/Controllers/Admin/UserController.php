<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();

        $user->update($data);
        if (isset($data['role']) && auth()->user()->role >= UserRole::Admin->value) {
            $user->role = $data['role'];
            $user->save();
        }

        return redirect(route('users.index'));
    }
}