<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganisationRequest;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Organisation::class);

        return Organisation::all();
    }

    public function store(OrganisationRequest $request)
    {
        $this->authorize('create', Organisation::class);

        return Organisation::create($request->validated());
    }

    public function show(Organisation $organisation)
    {
        $this->authorize('view', $organisation);

        return $organisation;
    }

    public function update(OrganisationRequest $request, Organisation $organisation)
    {
        $this->authorize('update', $organisation);

        $organisation->update($request->validated());

        return $organisation;
    }

    public function destroy(Organisation $organisation)
    {
        $this->authorize('delete', $organisation);

        $organisation->delete();

        return response()->json();
    }
}
