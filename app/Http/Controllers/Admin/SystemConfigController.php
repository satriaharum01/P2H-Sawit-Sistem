<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemConfig;
use Carbon\Carbon;
use DataTables;

class SystemConfigController extends Controller
{
    public function index()
    {
        // Total User
        $this->dataLoad['totalUsers'] = User::count();
        $this->dataLoad['sectionTitle'] = 'Site Configuration';
        $this->dataLoad['tableTitle'] = 'General Settings';
        $this->dataLoad['showDatatablesSetting'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';

        return view('contents.partials.generalSetting', $this->dataLoad);
    }

    public function json()
    {
        $data = SystemConfig::all();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function find($id)
    {
        $data = SystemConfig::select('*')->where('id', $id)->first();
        $data->dataTitle = 'Update Setting'; 
        return json_encode($data);
    }
}
