<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDegree extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'degree_id', 'name', 'ordered', 'active'
    ];

    protected $cascadeDeletes = [
        'user_qualifications', 'job_sub_degrees'
    ];

    protected static function booted()
    {
        if (!\Route::is('manager*'))
        {
            static::addGlobalScope(new ActiveScope());
        }
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }

    public function user_qualifications()
    {
        return $this->hasMany(UserQualification::class);
    }

    public function job_sub_degrees()
    {
        return $this->hasMany(JobSubDegree::class);
    }
}
