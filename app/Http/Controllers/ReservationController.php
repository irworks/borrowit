<?php

namespace App\Http\Controllers;

// TODO: Auth Middleware
use App\Models\ItemStack;

class ReservationController extends Controller
{
    /**
     * Show the current reservation
     * @return void
     */
    public function edit()
    {
        // TODO: Display from -> to selection
        // TODO: Check availability for all itemStacks in their quantities
        // TODO: Display error list if not available with concrete dates
        // TODO: Display submit button
    }

    public function add()
    {
        // TODO: find current reservation or create new
        // TODO: Add ItemStack from request to $reservation->ReservationItemStacks
        // TODO: redirect to edit()
    }

    public function submit()
    {
        // TODO: Submit reservation, set submitted_at = NOW()
    }
}