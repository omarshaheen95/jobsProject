<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'iso3', 'iso2', 'phone_code', 'timezone', 'latitude', 'longitude', 'flag', 'active'
    ];
}
