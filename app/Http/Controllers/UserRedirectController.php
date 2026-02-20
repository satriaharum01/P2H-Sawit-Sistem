<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserRedirectController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if ($user->role->name === 'Admin') {
            return redirect()->route('account.dashboard');
        }

        if ($user->role->name === 'Manager') {
            return redirect()->route('account.operation.dashboard');
        }

        if ($user->role->name === 'Operator') {
            return redirect()->route('operation.dashboard');
        }

        abort(403);
    }
}
