<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Position extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'name', 'ordered', 'active', 'job_grade'
    ];

    protected $cascadeDeletes = [
        'job_offers'
    ];

    protected static function booted()
    {

    }

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }

    public function job_offers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function scopeActive(Builder $query)
    {
        return
            $query->where('active', 1);

    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($name = $request->get('name', false), function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });

    }
}
