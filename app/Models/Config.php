<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Config extends Model
{
    use HasFactory;
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $fillable = ['name','value'];

}
