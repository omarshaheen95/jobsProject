<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_job_offer_id', 'interview_date', 'interview_place'
    ];

    public function user_job_offer()
    {
        return $this->belongsTo(UserJobOffer::class);
    }
}
