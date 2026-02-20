<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class P2HLog extends Model
{
    use HasFactory;

    protected $table = 'p2h_logs';

    protected $fillable = [
        'task_uuid',
        'user_id',
        'operator_name',
        'signature_path',
        'status',
        'log_date',
    ];

    public function assignment()
    {
        return $this->belongsTo(Item::class,'task_uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function values()
    {
        return $this->hasMany(P2HLogValue::class, 'p2h_log_id');
    }
}
