<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //gender 'male', 'female'
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'gender', 'dob', 'active', 'family_of_prisoners', 'injured_people', 'family_of_martyrs'
    ];

    protected $cascadeDeletes = [
        'user_qualifications', 'user_disabilities', 'user_experiences', 'user_languages', 'user_skills'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_qualifications()
    {
        return $this->belongsTo(UserQualification::class);
    }

    public function user_disabilities()
    {
        return $this->belongsTo(UserDisability::class);
    }

    public function user_experiences()
    {
        return $this->belongsTo(UserExperience::class);
    }

    public function user_languages()
    {
        return $this->belongsTo(UserLanguage::class);
    }

    public function user_skills()
    {
        return $this->belongsTo(UserSkill::class);
    }
}
