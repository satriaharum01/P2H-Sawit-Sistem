<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class P2HLog extends Model
{
    use HasFactory;

    protected $table = 'p2h_logs';

    protected $fillable = [
        'estate_id',
        'unit_id',
        'user_id',
        'signature_path',
        'status',
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function unit()
    {
        return $this->belongsTo(Item::class, 'unit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function values()
    {
        return $this->hasMany(P2HLogValue::class);
    }
}
