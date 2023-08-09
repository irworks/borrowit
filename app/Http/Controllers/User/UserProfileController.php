<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\OrganisationService;
use App\Services\UserService;

class UserProfileController extends AuthUserController
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