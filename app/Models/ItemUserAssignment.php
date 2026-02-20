<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ItemUserAssignment extends Model
{
    use HasFactory;

    protected $table = 'item_user_assignments';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'item_uuid',
        'user_id',
        'estate_uuid',
        'frequency',
        'start_date',
        'end_date',
        'is_active',
    ];

    public static $fieldTypes = [
        'item_uuid' => 'select',
        'user_id'      => 'select',
        'estate_uuid'      => 'select',
        'frequency'  => 'select',
        'start_date'  => 'date',
        'end_date'  => 'date',
        'is_active'   => 'boolean',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public static $fieldOptions = [
        'frequency' => ['daily' => 'Setiap Hari', 'weekly' => 'Setiap Minggu','monthly' => 'Setiap Bulan'],
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_uuid', 'uuid');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeToday($query)
    {
        return $query
            ->whereDate('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', now());
            });
    }

    public function scopeDaily($query)
    {
        return $query->where('frequency', 'daily');
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