<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    //gender : 'male', 'female'
    protected $fillable = [
        'job_uuid', 'name', 'slug', 'position_id', 'degree_id', 'content', 'functional_terms', 'functional_tasks', 'gender',
        'family_of_prisoners', 'injured_people', 'family_of_martyrs', 'start_at', 'end_at', 'publish_at', 'tags',
    ];

    protected $cascadeDeletes = [
        'languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function languages()
    {
        return $this->hasMany(JobLanguage::class);
    }

    public function governorates()
    {
        return $this->hasMany(JobGovernorate::class);
    }

    public function disabilities()
    {
        return $this->hasMany(JobDisability::class);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function sub_degrees()
    {
        return $this->hasMany(JobSubDegree::class);
    }

    public function ministries()
    {
        return $this->hasMany(JobMinistry::class);
    }
}
