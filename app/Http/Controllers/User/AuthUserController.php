<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

abstract class AuthUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function user()
    {
        return auth()->user();
    }
}