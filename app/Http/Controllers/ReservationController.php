<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\AuthUserController;
use App\Http\Requests\ReserveItemRequest;
use App\Http\Requests\UpdateReservationItemRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\ItemStack;
use App\Models\Reservation;
use App\Models\ReservationItemStack;
use App\Services\ReservationService;
use Carbon\Carbon;

class ReservationController extends AuthUserController
{
    private ReservationService $reservationService;
    public function __construct(ReservationService $reservationService)
    {
        parent::__construct();

        $this->reservationService = $reservationService;
    }

    /**
     * Show the current reservation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit()
    {
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $items = $this->reservationService->checkAvailability($reservation);

        return view('user.reservation.edit', [
            'reservation' => $reservation,
            'items' => $items
        ]);
    }

    /**
     * Checks the availability for the current reservation.
     * Reservation and items are loaded from the database (the current not submitted
     * reservation, which belongs to the current user)
     * @return \Illuminate\Http\JsonResponse
     */
    public function availability()
    {
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $items = $this->reservationService->checkAvailability($reservation);

        return response()->json([
            'data' => $items,
            'reservation' => [
                'from' => $reservation->from->format('Y-m-d\TH:i'),
                'to' => $reservation->to->format('Y-m-d\TH:i'),
            ]
        ]);
    }

    /**
     * Update the from and to datetimes for the current reservation.
     * @param UpdateReservationRequest $request
     * @return true
     */
    public function update(UpdateReservationRequest $request)
    {
        $data = $request->validated();
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $reservation->update([
            'from' => Carbon::createFromFormat('Y-m-d\TH:i', $data['from']),
            'to' => Carbon::createFromFormat('Y-m-d\TH:i', $data['to']),
        ]);

        return true;
    }

    public function updateItem(UpdateReservationItemRequest $request, ReservationItemStack $itemStack)
    {
        abort_if($itemStack->reservation->user_id !== $this->user()->id, 403);

        $data = $request->validated();

        if ($data['quantity'] <= 0) {
            $itemStack->delete();
        } else {
            $itemStack->update(['quantity' => $data['quantity']]);
        }

        return true;
    }

    /**
     * @param ReserveItemRequest $request
     * Add an ItemStack in a given quantity to the current reservation.
     * If no reservation exists, a new one will be created.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(ReserveItemRequest $request)
    {
        $data = $request->validated();
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $this->reservationService->addItemStack($reservation, $data['item_stack_id'], $data['quantity']);

        return redirect(route('reservation.edit'));
    }

    /**
     * Submit the current reservation.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit()
    {
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $success = $this->reservationService->submit($reservation);
        if ($success === false) {
            return back()->withErrors([__('reservation.failed')]);
        }

        return redirect(route('reservation.done'));
    }

    public function done()
    {
        return view('user.reservation.done');
    }

    public function cancel(Reservation $reservation)
    {
        abort_if($reservation->user_id !== auth()->user()->id || $reservation->isFulfilled(), 404);

        $reservation->reservationItemStacks()->delete();
        $reservation->delete();

        return back()->with('success', [__('reservation.retracted')]);
    }
}
