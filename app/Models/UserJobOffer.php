<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserJobOffer extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    //status : pending, approve, rejected
    protected $fillable = [
        'user_id', 'job_offer_id', 'status', 'manager_id', 'note'
    ];

    protected $appends = [
        'status_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusNameAttribute($value)
    {
        switch ($this->status) {
            case 'pending':
                return 'قيد الإنتظار';
            case 'approve':
                return 'مقبول';
            case 'rejected':
                return 'مرفوض';
            default:
                return null;
        }
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function interview()
    {
        return $this->hasOne(Interview::class);
    }

}
