<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
