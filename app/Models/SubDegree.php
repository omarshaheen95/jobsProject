<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDegree extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'degree_id', 'name', 'ordered', 'active'
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }
}
