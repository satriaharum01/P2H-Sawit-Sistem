<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemConfig extends Model
{
    use HasFactory;

    protected $table = 'system_configs';

    protected $fillable = [
        'config_key',
        'config_value',
        'config_type',
    ];

    public $timestamps = true;

    public static function getValue($key, $default = null)
    {
        $value = self::where('config_key', $key)->value('config_value');

        return $value ?? $default;
    }
}
