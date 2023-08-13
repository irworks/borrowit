<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\AuthUserController;
use App\Http\Requests\ReserveItemRequest;
use App\Models\ItemStack;
use App\Services\ReservationService;

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

        // TODO: Display from -> to selection
        // TODO: Check availability for all itemStacks in their quantities
        // TODO: Display error list if not available with concrete dates
        // TODO: Display submit button

        return view('reservation.edit', [
            'reservation' => $reservation,
            'items' => $items
        ]);
    }

    public function availability()
    {
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $items = $this->reservationService->checkAvailability($reservation);

        return response()->json([
            'data' => $items
        ]);
    }


    public function add(ReserveItemRequest $request)
    {
        $data = $request->validated();
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $this->reservationService->addItemStack($reservation, $data['item_stack_id'], $data['quantity']);

        return redirect(route('reservation.edit'));
    }

    public function submit()
    {
        $reservation = $this->reservationService->currentReservationForUser($this->user());
        $result = $this->reservationService->submit($reservation);
        dd($result);

        // TODO: Submit reservation, set submitted_at = NOW()
    }
}