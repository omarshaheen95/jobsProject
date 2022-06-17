<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'uid', 'full_name', 'mobile', 'phone', 'gender', 'dob', 'marital_status', 'number_of_children', 'number_of_employees',
        'scholarship_student', 'top_ten_students', 'birth_governorate_id', 'governorate_id', 'address', 'unemployed', 'work_nonGovernmental_org',
        'registered_unemployed_ministry', 'family_of_prisoners', 'injured_people', 'family_of_martyrs',
    ];

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
