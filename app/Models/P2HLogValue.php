<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2HLogValue extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'p2h_log_id',
        'attribute_id',
        'value_boolean',
        'photo_path',
    ];

    protected $casts = [
        'value_boolean' => 'boolean',
    ];

    public function log()
    {
        return $this->belongsTo(P2HLog::class, 'p2h_log_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
