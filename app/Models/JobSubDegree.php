<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSubDegree extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_offer_id', 'sub_degree_id',
    ];

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function sub_degree()
    {
        return $this->belongsTo(SubDegree::class);
    }
}
