<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOption\Option;

class UserJobOfferOption extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_job_offer_id', 'question_id', 'option_id'
    ];

    public function userJobOffer()
    {
        return $this->belongsTo(UserJobOffer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(QuestionOption::class);
    }
}
