<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\User\AuthUserController;
use App\Http\Requests\ReturnBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ReservationResource;
use App\Models\Booking;
use App\Models\Reservation;
use App\Services\BookingService;
use App\Services\ReservationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ManagerBookingController extends AuthUserController
{
    private BookingService $bookingService;

    /**
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        parent::__construct();
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $this->authorize('viewAny', Booking::class);

        return view('bookings.index', ['bookings' => $this->bookingService->index()->paginate()]);
    }

    /**
     * Display scanner UI for managers when a user returned their items.
     * @param Booking $booking
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function return(Booking $booking)
    {
        $this->authorize('return', $booking);

        return view('bookings.return', ['booking' => $booking]);
    }

    /**
     * Get details about a reservation, either as a JSON response
     * or as a view for browser display.
     * @param Reservation $reservation
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function details(Booking $booking)
    {
        $this->authorize('view', $booking);

        if (request()->expectsJson()) {
            return response()->json([
                'data' => new BookingResource($booking),
            ]);
        }
    }

    /**
     * Return items for a booking.
     * @param Booking $booking
     * @param ReturnBookingRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function complete(Booking $booking, ReturnBookingRequest $request)
    {
        $this->authorize('return', $booking);
        $data = $request->validated();

        $result = $this->bookingService->returnItems($booking, $data['itemIds']);
        if (request()->expectsJson()) {
            return response()->json([
                'result' => $result,
            ]);
        }

        return redirect(route('bookings.index'));
    }
}
