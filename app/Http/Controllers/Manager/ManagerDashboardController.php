<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\User\AuthUserController;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\BookingService;
use App\Services\ReservationService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ManagerDashboardController extends AuthUserController
{
    public function index(ReservationService $reservationService, BookingService $bookingService, UserService $userService)
    {
        $this->authorize('viewAny', Reservation::class);

        return view('dashboard.index', [
            'openReservations' => $reservationService->indexOpen(),
            'openBookings' => $bookingService->index(),
            'users' => $userService->index()
        ]);
    }
}
