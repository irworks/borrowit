<?php

namespace App\Models;

use Illuminate\Support\Collection;

interface Rental
{
    public function isOpen(): bool;
    public function getFinishedAtAttribute();
    public function itemStackNames() :Collection;
    public function itemStackNamesString(): string;
}
