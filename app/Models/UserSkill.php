<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSkill extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'position', 'work_place', 'work_now', 'start_at', 'end_at', 'end_reasons'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
