<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttributeValue extends Model
{
    protected $table = 'item_attribute_values';

    protected $fillable = [
        'item_id',
        'attribute_id',
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
        'item_id' => 'select',
        'attribute_id'     => 'select',
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
            'item_id' => [
                'type' => 'select',
                'label' => 'Item',
                'options' => [], 
                'placeholder' => '-- Pilih Item --',
                'required' => true
            ],
            'attribute_id' => [
                'type' => 'select',
                'label' => 'Attribute',
                'options' => [], 
                'placeholder' => '-- Pilih Attribute --',
                'required' => true
            ],
        ];
    }
}
