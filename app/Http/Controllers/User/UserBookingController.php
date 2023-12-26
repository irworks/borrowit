<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\BookingService;
use App\Services\OrganisationService;
use App\Services\ReservationService;
use App\Services\UserService;

class UserBookingController extends AuthUserController
{
    public function index(ReservationService $reservationService, BookingService $bookingService)
    {
        $showOnlyOpenReservations = request()->get('showOnlyOpenReservations', false) === 'true';
        $showOnlyOpenBookings = request()->get('showOnlyOpenBookings', false) === 'true';

        return view('user.bookings.index', [
            'reservations' => $reservationService->indexByUser($this->user(), $showOnlyOpenReservations)->get(),
            'bookings' => $bookingService->indexByUser($this->user(), $showOnlyOpenBookings)->get(),

            'showOnlyOpenReservations' => $showOnlyOpenReservations,
            'showOnlyOpenBookings' => $showOnlyOpenBookings
        ]);
    }
}
