<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOfferQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_offer_id', 'question_id',
    ];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
