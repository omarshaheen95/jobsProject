<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobQualification extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_offer_id', 'qualification_id',
    ];

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }
}
