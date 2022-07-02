<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query->whereHas('user', function ($query) use($request) {
                $query->when($name = $request->get('name', false), function ($query) use ($name) {
                    $query->where(function($query) use($name){
                        $query->where('name', 'like', '%' . $name . '%')
                            ->orWhereHas('userInfo', function ($query) use ($name) {
                                $query->where('full_name', 'like', '%' . $name . '%');
                            });
                    });
                })
                    ->whereHas('userInfo', function ($query) use ($request) {
                        $query->when($governorate = $request->get('governorate_id', false), function ($query) use ($governorate) {
                            $query->where('governorate_id', $governorate);
                        });
                        $query->when($governorate = $request->get('governorate_id', false), function ($query) use ($governorate) {
                            $query->where('governorate_id', $governorate);
                        });
                        $query->when($uid = $request->get('uid', false), function ($query) use ($uid) {
                            $query->where('uid', $uid);
                        });
                        $query->when($mobile = $request->get('mobile', false), function ($query) use ($mobile) {
                            $query->where('mobile',  'like', '%' .$mobile. '%');
                        });
                        $query->when($gender = $request->get('gender', false), function ($query) use ($gender) {
                            $query->where('gender', $gender);
                        });
                    });
            })
                ->when($status = $request->get('status', false), function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($start_at = $request->get('start_date', false), function ($query) use ($start_at) {
                    $query->whereDate('created_at', '>=', $start_at);
                })
                ->when($end_at = $request->get('end_date', false), function ($query) use ($end_at) {
                    $query->whereDate('created_at', '<=', $end_at);
                })
                ->when($request->get('interview', false)  == 1 , function ($query)  {
                    $query->has('interview');
                })
                ->when($request->get('interview', false) == 2, function ( $query)  {
                    $query->doesntHave('interview');
                });

    }

}
