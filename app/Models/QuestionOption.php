<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class QuestionOption extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'question_id', 'option', 'result',
    ];

    public $cascadeDeletes = [

    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function optionResult($job_offer_id)
    {
        $result = UserJobOfferOption::query()
            ->where('user_job_offer_id', $job_offer_id)
            ->where('option_id', $this->id)
//            ->where('question_id', $this->question_id)
            ->first();
        Log::alert($result);
        if ($result)
        {
            return true;
        }else{
            return  false;
        }
    }
}
