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
