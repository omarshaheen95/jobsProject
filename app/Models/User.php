<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
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
        'name', 'email', 'password', 'active',
    ];

    protected $cascadeDeletes = [
        'userQualifications', 'userDisabilities', 'userExperiences', 'userLanguages', 'userSkills', 'userInfo', 'jobOffers'
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

    public function userQualifications()
    {
        return $this->hasMany(UserQualification::class);
    }

    public function userDisabilities()
    {
        return $this->hasMany(UserDisability::class);
    }

    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, UserJobOffer::class)->withPivot(['created_at', 'status']);
    }

    public function getStatusAttribute($value)
    {
        if ($this->pivot) {
            switch ($this->pivot->status) {
                case 'pending':
                    return 'قيد الإنتظار';
                case 'approve':
                    return 'مقبول';
                case 'rejected':
                    return 'مرفوض';
            }
        } else {
            return null;
        }
    }


    public function userExperiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function userLanguages()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query->when($name = $request->get('name', false), function ($query) use ($name) {
                $query->where(function($query) use($name){
                    $query->where('name', 'like', '%' . $name . '%')
                        ->orWhereHas('userInfo', function ($query) use ($name) {
                            $query->where('full_name', 'like', '%' . $name . '%');
                        });
                });
            })
            ->whereHas('userInfo', function ($query) use ($request) {
                $query->when($governorate = $request->get('governorate_id', false), function ($query) use ($governorate) {
                    $query->where('governorate_id', $governorate);
                });
                $query->when($governorate = $request->get('governorate_id', false), function ($query) use ($governorate) {
                    $query->where('governorate_id', $governorate);
                });
                $query->when($uid = $request->get('uid', false), function ($query) use ($uid) {
                    $query->where('uid', $uid);
                });
                $query->when($mobile = $request->get('mobile', false), function ($query) use ($mobile) {
                    $query->where('mobile',  'like', '%' .$mobile. '%');
                });
                $query->when($gender = $request->get('gender', false), function ($query) use ($gender) {
                    $query->where('gender', $gender);
                });
            });
    }
}
