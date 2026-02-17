<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleRoutePermission extends Model
{
    use HasFactory;

    protected $table = 'role_route_permissions';

    protected $fillable = [
        'role_id',
        'route_config_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function route()
    {
        return $this->belongsTo(RouteConfig::class, 'route_config_id');
    }
}
