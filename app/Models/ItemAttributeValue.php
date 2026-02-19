<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ItemAttributeValue extends Model
{
    use HasUuids;

    protected $table = 'item_attribute_values';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'item_uuid',
        'attribute_uuid',
        'value_string',
        'value_number',
        'value_boolean',
        'value_date',
    ];

    protected $casts = [
        'value_boolean' => 'boolean',
        'value_number'  => 'float',
        'value_date'    => 'date',
    ];

    public static $fieldTypes = [
        'item_uuid' => 'select',
        'attribute_uuid'     => 'select',
        'value_string'      => 'text',
        'value_number'  => 'number',
        'value_boolean'  => 'boolean',
        'value_date'  => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    
    public static function getFormSettings()
    {
        return [
            'item_uuid' => [
                'type' => 'select',
                'label' => 'Item',
                'options' => [], 
                'placeholder' => '-- Pilih Item --',
                'required' => true
            ],
            'attribute_uuid' => [
                'type' => 'select',
                'label' => 'Attribute',
                'options' => [], 
                'placeholder' => '-- Pilih Attribute --',
                'required' => true
            ],
        ];
    }
}
