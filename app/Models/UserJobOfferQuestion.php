<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJobOfferQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_job_offer_id', 'question_id', 'answer'
    ];

    public function userJobOffer()
    {
        return $this->belongsTo(UserJobOffer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
