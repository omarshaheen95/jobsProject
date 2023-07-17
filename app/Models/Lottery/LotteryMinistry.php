<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class LotteryMinistry extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'lottery_governorate_id', 'active', 'discrimination', 'completed', 'priority', 'top'
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function lotteries()
    {
        return $this->hasMany(Lottery::class);
    }

    public function lottery_governorate()
    {
        return $this->hasMany(LotteryGovernorate::class);
    }

    public function getStatusAttribute()
    {
        return $this->discrimination ? 'استثناء':'بدون استثناء';
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($name = $request->get('name', false), function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($request->get('discrimination', false) == 1, function ($query) {
                    $query->where('discrimination', 1);
                })
                ->when($request->get('discrimination', false) == 2, function ($query) {
                    $query->where('discrimination', 0);
                });

    }
}
