<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'name', 'iso3', 'iso2', 'phone_code', 'timezone', 'latitude', 'longitude', 'flag', 'active'
    ];

    protected $cascadeDeletes = [
        'user_qualifications'
    ];

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }

    public function user_qualifications()
    {
        return $this->hasMany(UserQualification::class);
    }
}
