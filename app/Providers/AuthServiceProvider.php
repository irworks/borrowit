<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemStack;
use App\Models\Organisation;
use App\Models\RegisterDomain;
use App\Models\Reservation;
use App\Models\User;
use App\Policies\AdminSettingsPolicy;
use App\Policies\BookingPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ItemPolicy;
use App\Policies\ItemStackPolicy;
use App\Policies\OrganisationPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Organisation::class => OrganisationPolicy::class,
        Category::class => CategoryPolicy::class,
        ItemStack::class => ItemStackPolicy::class,
        Item::class => ItemPolicy::class,
        User::class => UserPolicy::class,
        Reservation::class => ReservationPolicy::class,
        Booking::class => BookingPolicy::class,
        RegisterDomain::class => AdminSettingsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
