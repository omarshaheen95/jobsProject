<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
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
        'languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries', 'users'
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
        return $this->belongsToMany(Governorate::class, JobGovernorate::class);
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, JobDisability::class);
    }

    public function qualifications()
    {
        return $this->belongsToMany(Qualification::class, JobQualification::class);
    }

    public function sub_degrees()
    {
        return $this->belongsToMany(SubDegree::class, JobSubDegree::class);
    }

    public function ministries()
    {
        return $this->belongsToMany(Ministry::class, JobMinistry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, UserJobOffer::class)->withPivot(['status', 'created_at']);
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

    public function getGenderNameAttribute()
    {
        switch ($this->gender)
        {
            case 'male': return 'ذكر';
            case 'female': return 'أنثى';
            default: return 'الكل';
        }
    }

    public function getFamilyOfPrisonersNameAttribute()
    {
        switch ($this->family_of_prisoners)
        {
            case 1: return 'ذوي الأسرى';
            case 2: return 'العاديين';
            default: return 'الكل';
        }
    }

    public function getInjuredPeopleNameAttribute()
    {
        switch ($this->injured_people)
        {
            case 1: return 'ذوي الجرحى';
            case 2: return 'العاديين';
            default: return 'الكل';
        }
    }

    public function getFamilyOfMartyrsNameAttribute()
    {
        switch ($this->family_of_martyrs)
        {
            case 1: return 'ذوي الشهداء';
            case 2: return 'العاديين';
            default: return 'الكل';
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($name = $request->get('name', false), function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($job_uuid = $request->get('job_uuid', false), function ($query) use ($job_uuid) {
                    $query->where('job_uuid', 'like', '%' . $job_uuid . '%');
                })
                ->when($position = $request->get('position_id', false), function ($query) use ($position) {
                    $query->where('position_id', $position);
                });

    }



}
