<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\User\AuthUserController;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\BookingService;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ManagerReservationController extends AuthUserController
{
    private ReservationService $reservationService;

    /**
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        parent::__construct();
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $this->authorize('viewAny', Reservation::class);

        return view('reservations.index', ['reservations' => $this->reservationService->index()->paginate()]);
    }

    /**
     * Display scanner UI for managers when a user wants to collect their reservation.
     * @param Reservation $reservation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function collect(Reservation $reservation)
    {
        $this->authorize('collect', $reservation);

        return view('reservations.collect', ['reservation' => $reservation]);
    }

    /**
     * Get details about a reservation, either as a JSON response
     * or as a view for browser display.
     * @param Reservation $reservation
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function details(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => new ReservationResource($reservation),
            ]);
        }
    }

    /**
     * Create a Booking from a Reservation
     * @param Reservation $reservation
     * @param BookingService $bookingService
     * @param StoreBookingRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function book(Reservation $reservation, BookingService $bookingService, StoreBookingRequest $request)
    {
        $this->authorize('collect', $reservation);
        $data = $request->validated();

        $success = $bookingService->store($reservation, $data['itemIds']);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => $success,
            ]);
        }

        return redirect(route('reservations.index'));
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        // TODO: Notify!
        $reservation->reservationItemStacks()->delete();
        $reservation->delete();

        return redirect(route('reservations.index'));
    }
}
