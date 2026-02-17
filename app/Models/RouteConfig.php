<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteConfig extends Model
{
    use HasFactory;

    protected $table = 'routes_config';

    protected $fillable = [
        'route_name',
        'label',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function permissions()
    {
        return $this->hasMany(RoleRoutePermission::class, 'route_config_id');
    }
}
