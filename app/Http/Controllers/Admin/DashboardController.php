<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemConfig;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total User
        $this->dataLoad['totalUsers'] = User::count();
        $this->dataLoad['sectionTitle'] = 'Admin Dashboard';

        return view('contents.dashboard', $this->dataLoad);
    }
}
