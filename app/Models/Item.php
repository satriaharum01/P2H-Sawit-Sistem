<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'estate_id',
        'code',
        'name',
        'category',
        'subtype',
        'status',
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(ItemAttributeValue::class);
    }

    public function p2hLogs()
    {
        return $this->hasMany(P2HLog::class, 'unit_id');
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->role->name === 'Admin') {
            return $query;
        }

        if ($user->role->name === 'Manager') {
            return $query;
        }

        return $query->where('estate_id', $user->estate_id);
    }

}
