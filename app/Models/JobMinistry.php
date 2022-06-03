<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobMinistry extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'job_offer_id', 'ministry_id'
    ];

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
}
