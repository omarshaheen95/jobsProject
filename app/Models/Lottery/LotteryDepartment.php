<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class LotteryDepartment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'active', 'governor', 'lottery_ministry_id'
    ];

    public function lottery_ministry()
    {
        return $this->belongsTo(LotteryMinistry::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($name = $request->get('name', false), function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($request->get('governor', false) == 1, function ($query) {
                    $query->where('governor', 1);
                })
                ->when($request->get('governor', false) == 2, function ($query) {
                    $query->where('governor', 0);
                })
                ->when($ministry = $request->get('ministry', false) , function ($query) use($ministry) {
                    $query->where('lottery_ministry_id', $ministry);
                });

    }
}
