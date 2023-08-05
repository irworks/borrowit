<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\OrganisationService;
use App\Services\UserService;

// TODO: Extend auth controller
class UserProfileController extends Controller
{
    public function edit(OrganisationService $organisationService)
    {
        return view('profile.edit', [
            'user' => auth()->user(), 'organisations' => $organisationService->selectArray(true)
        ]);
    }

    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $data = $request->validated();
        $userService->update(auth()->user(), $data['phone'], $data['organisation_id'], $data['new-password']);

        return back();
    }
}