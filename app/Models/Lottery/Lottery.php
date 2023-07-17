<?php

namespace App\Models\Lottery;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Lottery extends Model
{
    use SoftDeletes;
    //type : 'general', 'discrimination', 'top', 'governor'
    protected $fillable = [
        'selected_grade', 'lottery_department_id', 'lottery_ministry_id', 'total', 'type', 'manager_id'
    ];

    public function lottery_department()
    {
        return $this->belongsTo(LotteryDepartment::class);
    }

    public function lottery_ministry()
    {
        return $this->belongsTo(LotteryMinistry::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($department = $request->get('department'), function ($q) use($department) {
                    $q->where('lottery_department_id', $department);
                })->when($ministry = $request->get('ministry'), function ($q) use($ministry) {
                    $q->where('lottery_ministry_id', $ministry);
                })->when($grade = $request->get('grade'), function ($q) use($grade) {
                    $q->where('selected_grade', $grade);
                })->when($type = $request->get('type'), function ($q) use($type) {
                    $q->where('type', $type);
                })->when($manager = $request->get('manager_id'), function ($q) use($manager) {
                    $q->where('manager_id', $manager);
                });

    }

}
