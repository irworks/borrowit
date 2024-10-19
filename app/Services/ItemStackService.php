<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ItemStack;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class ItemStackService
{
    public function saveUploadedImage(UploadedFile $image, ItemStack $itemStack): void
    {
        if (!file_exists($itemStack->imageSavePath())) {
            mkdir($itemStack->imageSavePath(), 0774, true);
        }

        $extension = $image->getClientOriginalExtension();
        $fileName = $itemStack->imageFileName($extension);

        $image->move($itemStack->imageSavePath(), $fileName);
        $itemStack->update(['image_uri' => $itemStack->imageSavePath(true) . '/' . $fileName]);
    }
}
