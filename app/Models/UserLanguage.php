<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLanguage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'language_id', 'notes', 'reading_rate', 'writing_rate', 'conversation_rate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
