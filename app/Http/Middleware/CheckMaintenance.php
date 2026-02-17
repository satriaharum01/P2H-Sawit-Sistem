<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemConfig;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next)
    {
        $maintenance = SystemConfig::where('config_key', 'maintenance_mode')
            ->value('config_value');

        if ($maintenance == '1') {

            if (Auth::check()) {
                if (Auth::user()->role->name === 'Admin') {
                    return $next($request);
                }
            }

            return response()->view('maintenance');
        }

        return $next($request);
    }
}

