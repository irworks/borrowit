<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterDomainRequest;
use App\Models\RegisterDomain;
use App\Services\SettingsService;

class AdminSettingsController extends Controller
{
    public function index(SettingsService $settingsService)
    {
        $this->authorize('viewAny', RegisterDomain::class);

        return view('settings.index', [
            'domains' => $settingsService->domains()
        ]);
    }

    public function storeDomain(StoreRegisterDomainRequest $domainRequest, SettingsService $settingsService)
    {
        $this->authorize('viewAny', RegisterDomain::class);

        $data = $domainRequest->validated();
        $settingsService->createDomain($data['domain']);

        return back()->with('success', [__('domain.created')]);
    }

    public function updateDomain(RegisterDomain $domain, StoreRegisterDomainRequest $domainRequest)
    {
        $this->authorize('viewAny', RegisterDomain::class);

        $data = $domainRequest->validated();
        $data['active'] = $domainRequest->has('active');
        $domain->update($data);

        return back()->with('success', [__('domain.updated')]);
    }

    public function deleteDomain(RegisterDomain $domain)
    {
        $this->authorize('viewAny', RegisterDomain::class);

        $domain->delete();

        return back()->with('success', [__('domain.deleted')]);
    }
}
