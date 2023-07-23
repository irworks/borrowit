<?php

namespace App\Models;

enum UserRole: int
{
    case User = 1;
    case Manager = 2;
    case Admin = 3;
}
