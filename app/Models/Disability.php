<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disability extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'name', 'ordered', 'active'
    ];

    protected $cascadeDeletes = [
        'job_disabilities', 'user_disabilities'
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

    public function job_disabilities()
    {
        return $this->hasMany(JobDisability::class);
    }

    public function user_disabilities()
    {
        return $this->hasMany(UserDisability::class);
    }
}
