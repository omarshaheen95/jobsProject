<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Grade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lottery_degree_id', 'lottery_university_id', 'lottery_college_id', 'lottery_department_id',
        'lottery_position_id', 'lottery_ministry_id', 'total_required', 'grade_required',
    ];

    public function lottery_degree()
    {
        return $this->belongsTo(LotteryDegree::class);
    }

    public function lottery_university()
    {
        return $this->belongsTo(LotteryUniversity::class);
    }

    public function lottery_college()
    {
        return $this->belongsTo(LotteryCollege::class);
    }

    public function lottery_department()
    {
        return $this->belongsTo(LotteryDepartment::class);
    }

    public function lottery_position()
    {
        return $this->belongsTo(LotteryPosition::class);
    }

    public function lottery_ministry()
    {
        return $this->belongsTo(LotteryMinistry::class);
    }

    public function departmentApplicants()
    {
        return $this->hasMany(Applicant::class, 'lottery_department_id', 'lottery_department_id');
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($department = $request->get('department'), function ($q) use($department) {
                    $q->where('lottery_department_id', $department);
                })->when($degree = $request->get('degree'), function ($q) use($degree) {
                    $q->where('lottery_degree_id', $degree);
                })->when($position = $request->get('position'), function ($q) use($position) {
                    $q->where('lottery_position_id', $position);
                })->when($university = $request->get('university'), function ($q) use($university) {
                    $q->where('lottery_university_id', $university);
                })->when($college = $request->get('college'), function ($q) use($college) {
                    $q->where('lottery_college_id', $college);
                })->when($ministry = $request->get('ministry'), function ($q) use($ministry) {
                    $q->where('lottery_ministry_id', $ministry);
                })->when($grade = $request->get('grade'), function ($q) use($grade) {
                    $q->where('grade_required', $grade);
                });

    }

}
