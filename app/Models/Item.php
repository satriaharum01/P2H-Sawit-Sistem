<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Item extends Model
{
    use HasUuids;
    
    protected $table = 'items';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'estate_uuid',
        'code',
        'name',
        'category',
        'subtype',
        'status',
    ];
    
    public static $fieldTypes = [
        'estate_uuid' => 'select',
        'code'      => 'text',
        'name'      => 'text',
        'category'  => 'select',
        'subtype'   => 'text',
        'status'    => 'select',
    ];

    public static $fieldOptions = [
        'category' => ['unit' => 'Unit', 'inventory' => 'Inventory','task' => 'Task'],
        'status'   => ['active' => 'Aktif', 'inactive' => 'Non-Aktif'],
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
    
    public function attributes()
    {
        // Mengambil Attribute melalui ItemAttributeValue
        return $this->hasManyThrough(
            Attribute::class,           // Model Tujuan
            ItemAttributeValue::class,  // Model Perantara
            'item_uuid',                  // Foreign key di tabel perantara
            'uuid',                       // Foreign key di tabel tujuan (Attribute)
            'uuid',                       // Local key di tabel Item
            'attribute_uuid'              // Local key di tabel perantara
        );
    }

    public function attributeValues()
    {
        return $this->hasMany(ItemAttributeValue::class, 'item_uuid', 'uuid');
    }
    
    public function assignments()
    {
        return $this->hasMany(ItemUserAssignment::class, 'item_uuid', 'uuid');
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->role->name === 'Admin') {
            return $query;
        }

        if ($user->role->name === 'Manager') {
            return $query;
        }

        return $query->where('estate_uuid', $user->estate_uuid);
    }

    public static function getFormSettings()
    {
        return [
            'estate_uuid' => [
                'type' => 'select',
                'label' => 'Estate',
                'options' => [], 
                'placeholder' => '-- Pilih Estate --'
            ],
            'code' => [
                'type' => 'text',
                'label' => 'Kode Item',
                'placeholder' => 'Masukkan kode...',
                'required' => true
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Nama Item',
                'placeholder' => 'Masukkan nama...',
                'required' => true
            ],
            'category' => [
                'type' => 'select',
                'label' => 'Category',
                'options' => self::$fieldOptions['category']
            ],
            'subtype' => [
                'type' => 'text',
                'label' => 'Deskripsi Subtype',
                'placeholder' => 'Masukkan Subtype...',
                'required' => true
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status Aktif',
                'options' => self::$fieldOptions['status']
            ],
        ];
    }
}
