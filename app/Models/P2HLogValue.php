<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P2HLogValue extends Model
{
    protected $table = 'p2h_log_values';

    protected $fillable = [
        'p2h_log_id',
        'attribute_uuid',
        'status',
        'value_string',
        'value_number',
        'value_boolean',
        'value_date',
        'description',
        'photo_path',
    ];

    public static $fieldTypes = [
        'p2h_log_id' => 'id',
        'attribute_uuid'     => 'id',
        'value_string'      => 'text',
        'value_number'  => 'number',
        'value_boolean'  => 'boolean',
        'value_date'  => 'date',
        'description'  => 'textarea',
        'photo_path'  => 'image',
    ];

    public static  $fieldLabels = [
        'value_string' => 'Respon Anda',
        'value_number' => 'Masukkan Nilai',
        'value_boolean' => 'Kondisi Sesuai ?',
        'value_date' => 'Masukkan Tanggal',
    ];

    public function log()
    {
        return $this->belongsTo(P2HLog::class, 'p2h_log_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }


    public static function getFormSettings()
    {
        $fields = [];

        foreach (self::$fieldTypes as $key => $type) {

            $fields[$key] = [
                'type'  => $type,
                'label' => self::$fieldLabels[$key] ?? ucwords(str_replace('_', ' ', $key)),
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
            } elseif ($type === 'image') {
                $fields[$key]['placeholder'] = 'Upload Image';
            } else {
                $fields[$key]['placeholder'] = 'Masukkan ' . $key;
            }

        }
        
        return $fields;
    }
}
