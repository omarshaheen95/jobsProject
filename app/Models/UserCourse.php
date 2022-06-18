<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCourse extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'course_name', 'course_place', 'course_hours', 'start_at', 'end_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
