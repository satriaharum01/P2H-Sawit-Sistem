<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'estate_id',
        'name',
        'code',
        'data_type',
        'is_required',
        'is_critical',
        'category_scope',
        'applies_to_subtype',
        'is_active'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_critical' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function values()
    {
        return $this->hasMany(ItemAttributeValue::class);
    }
}
