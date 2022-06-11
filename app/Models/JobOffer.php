<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class JobOffer extends Model implements HasMedia
{
    use SoftDeletes, CascadeSoftDeletes, HasSlug, InteractsWithMedia;

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
        return $this->belongsToMany(Language::class, JobLanguage::class);
    }

    public function governorates()
    {
        return $this->belongsToMany(Governorate::class,JobGovernorate::class);
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class,JobDisability::class);
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class,JobQualification::class);
    }

    public function sub_degrees()
    {
        return $this->belongsToMany(SubDegree::class,JobSubDegree::class);
    }

    public function ministries()
    {
        return $this->belongsToMany(Ministry::class,JobMinistry::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }
}
