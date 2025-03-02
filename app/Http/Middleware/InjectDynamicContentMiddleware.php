<?php

namespace App\Http\Middleware;

use App\Models\DynamicContent;
use Closure;
use Illuminate\Http\Request;

class InjectDynamicContentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        \View::share(['dynamicContent' => DynamicContent::get()->keyBy('slot')]);
        return $next($request);
    }
}
