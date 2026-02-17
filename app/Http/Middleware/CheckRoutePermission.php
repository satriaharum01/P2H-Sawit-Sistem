<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoutePermission;

class CheckRoutePermission
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/auth');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect('/auth')->withErrors('User tidak aktif.');
        }

        if (!$user->role) {
            abort(403, 'User belum memiliki role.');
        }
       
        // Admin bypass semua
        if ($user->role->name === 'Admin') {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        $allowed = RoutePermission::where('role_id', $user->role_id)
            ->where('route_name', $routeName)
            ->exists();

        if (!$allowed) {
            abort(403, 'Tidak punya akses.');
        }

        return $next($request);
    }
}

