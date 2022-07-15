<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Question extends Model
{
    use SoftDeletes;
    //type : 'radio', 'checkbox', 'writing', 'file'
    protected $fillable = [
        'question', 'type',
    ];

    protected $appends = [
        'type_name'
    ];

    public function getTypeNameAttribute()
    {
        switch($this->type)
        {
            case "radio":
                return 'اختيار مفرد';
            case "checkbox":
                return 'اختيار متعدد';
            case "writing":
                return 'كتابي';
            case "file":
                return 'ملف مرفق (PDF)';
        }
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($question = $request->get('name', false), function ($query) use ($question) {
                    $query->where('question', 'like', '%' . $question . '%');
                })
                ->when($type  = $request->get('question_type', false), function (Builder $query) use ($type) {
                    $query->where('type', $type);
                });

    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
