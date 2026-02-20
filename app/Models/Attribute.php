<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Attribute extends Model
{
    use HasUuids;

    protected $table = 'attributes';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'estate_uuid',
        'name',
        'code',
        'data_type',
        'is_required',
        'is_critical',
        'category_scope',
        'applies_to_subtype',
        'is_active'
    ];

    public static $fieldTypes = [
        'estate_uuid' => 'select',
        'code'      => 'text',
        'name'      => 'text',
        'data_type'  => 'select',
        'category_scope'  => 'select',
        'applies_to_subtype'  => 'select',
        'is_required' => 'boolean',
        'is_critical' => 'boolean',
        'is_active'   => 'boolean',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_critical' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public static $fieldOptions = [
        'data_type'  => ['string' => 'Text', 'number' => 'Nomor','boolean' => 'True/False','date' => 'Tanggal','image' => 'Gambar'],
        'category_scope' => ['unit' => 'Unit', 'inventory' => 'Inventory','task' => 'Task'],
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function values()
    {
        return $this->hasMany(ItemAttributeValue::class);
    }

    public function logValues()
    {
        return $this->hasMany(P2HLogValue::class);
    }

    public static function getFormSettings()
    {
        $fields = [];

        foreach (self::$fieldTypes as $key => $type) {

            $fields[$key] = [
                'type'  => $type,
                'label' => ucwords(str_replace('_', ' ', $key)),
            ];

            // kalau select, inject options
            if ($type === 'select') {
                $fields[$key]['options'] = self::$fieldOptions[$key] ?? [];
                $fields[$key]['placeholder'] = '-- Pilih '. ucwords(str_replace('_', ' ', $key)) . '--';
            }

            // custom tambahan per field (kalau perlu)
            if (in_array($key, ['code', 'name', 'subtype'])) {
                $fields[$key]['required'] = true;
            }

            if ($type === 'boolean') {
                $fields[$key]['placeholder'] = ucwords(str_replace('_', ' ', $key));
            }else{
                $fields[$key]['placeholder'] = 'Masukkan ' . $key;
            }

        }

        return $fields;
    }
}
