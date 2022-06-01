<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appreciation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'ordered', 'active'
    ];

    public function getStatusAttribute()
    {
        return $this->active ? 'فعالة':'غير فعالة';
    }
}
