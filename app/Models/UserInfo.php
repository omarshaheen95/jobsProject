<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserInfo extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;
    protected $fillable = [
        'user_id', 'uid', 'full_name', 'mobile', 'phone', 'gender', 'dob', 'marital_status', 'number_of_children', 'number_of_employees',
        'scholarship_student', 'top_ten_students', 'birth_governorate_id', 'governorate_id', 'address', 'unemployed', 'work_nonGovernmental_org',
        'registered_unemployed_ministry', 'family_of_prisoners', 'injured_people', 'family_of_martyrs',
    ];

    protected $appends = [
        'gender_name', 'marital_status_name'
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('users')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('minImage')
            ->width(100)
            ->height(100)
            ->sharpen(10);
    }

    public function getGenderNameAttribute()
    {
        return $this->gender == 'male' ? 'ذكر':'أنثى';
    }

    public function getMaritalStatusNameAttribute()
    {
        switch ($this->marital_status)
        {
            case 1: return 'أعزب';
            case 2: return 'متزوج/ة';
            case 3: return 'مطلق/ة';
            case 4: return 'أرمل/ة';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function birthGovernorate()
    {
        return $this->belongsTo(Governorate::class, 'birth_governorate_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }


}
