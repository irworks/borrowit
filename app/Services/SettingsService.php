<?php

namespace App\Services;

use App\Models\RegisterDomain;

class SettingsService
{
    public function domains(): \Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\_IH_RegisterDomain_C
    {
        return RegisterDomain::all();
    }

    public function createDomain(string $domainName): void
    {
        RegisterDomain::create(['domain' => \Str::replaceStart('@', '', $domainName), 'active' => true]);
    }
}
