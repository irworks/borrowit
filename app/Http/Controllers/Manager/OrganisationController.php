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

        return view('organisations.index', ['organisations' => Organisation::all()]);
    }

    public function store(OrganisationRequest $request)
    {
        $this->authorize('create', Organisation::class);

        return redirect(route('organisations.index'));
    }

    public function update(OrganisationRequest $request, Organisation $organisation)
    {
        $this->authorize('update', $organisation);

        $organisation->update($request->validated());

        return redirect(route('organisations.index'));
    }

    public function destroy(Organisation $organisation)
    {
        $this->authorize('delete', $organisation);

        $organisation->delete();

        return redirect(route('organisations.index'));
    }
}
