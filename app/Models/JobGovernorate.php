<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobGovernorate extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_offer_id', 'governorate_id',
    ];

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
