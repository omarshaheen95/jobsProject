<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ministry extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'name', 'ordered', 'active'
    ];

    protected static function booted()
    {
        if (!\Route::is('manager*'))
        {
            static::addGlobalScope(new ActiveScope());
        }
    }

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }

    public function job_ministries()
    {
        return $this->hasMany(JobMinistry::class);
    }

    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, JobMinistry::class);
    }
}
