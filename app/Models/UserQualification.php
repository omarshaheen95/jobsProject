<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQualification extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'qualification_id', 'degree_id', 'sub_degree_id', 'country_id', 'appreciation_id', 'graduation_place', 'average', 'graduation_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function sub_degree()
    {
        return $this->belongsTo(SubDegree::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function appreciation()
    {
        return $this->belongsTo(Appreciation::class);
    }

}
