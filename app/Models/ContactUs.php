<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'governorate_id', 'name', 'mobile', 'email', 'message', 'seen'
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
