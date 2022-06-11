<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'ordered', 'active'
    ];

    protected $cascadeDeletes = [
        'job_offers', 'sub_degrees'
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

    public function job_offers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function sub_degrees()
    {
        return $this->hasMany(SubDegree::class);
    }
}
