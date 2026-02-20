<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemConfig;
use Carbon\Carbon;

class OperationDashboardController extends Controller
{
    public function index()
    {
        // Total User
        $this->dataLoad['totalUsers'] = User::count();
        $this->dataLoad['sectionTitle'] = 'Operation Dashboard';

        return view('contents.dashboard', $this->dataLoad);
    }
}
