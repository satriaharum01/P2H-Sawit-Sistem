<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//Load Models
use App\Models\SystemConfig;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $dataLoad;
    public $allValueColumns = ['value_string', 'value_number', 'value_boolean', 'value_date'];
    
    public function __construct()
    {
        $this->dataLoad['maintenanceMode'] = SystemConfig::getValue('maintenance_mode', 0);
        $this->dataLoad['siteName'] = SystemConfig::getValue('site_name', 0);
    }
}
