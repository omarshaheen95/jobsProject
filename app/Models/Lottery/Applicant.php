<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Applicant extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'average', 'sequencing', 'code', 'password', 'graduation_year', 'lottery_university_id',
        'lottery_college_id', 'lottery_department_id', 'lottery_degree_id', 'selected_grade', 'study_type',
        'mobile', 'gender', 'lottery_governorate_id', 'lottery_ministry_id', 'lottery_id',
    ];
    protected $appends = [
        'fake_code'
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

    public function lottery_governorate()
    {
        return $this->belongsTo(LotteryGovernorate::class);
    }

    public function lottery_ministry()
    {
        return $this->belongsTo(LotteryMinistry::class);
    }

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }

    public function getFakeCodeAttribute()
    {
        return str_pad( $this->id, 7, "0", STR_PAD_LEFT ); //'applicant-' . ;
    }

    public function scopeSearch(Builder $query, Request $request)
    {
        return
            $query
                ->when($name = $request->get('name', false), function ($q) use($name){
                    $q->where('name', 'like', '%' .$name. '%');
                })->when($average = $request->get('average', false), function ($q) use($average){
                    $q->where('average', $average);
                })->when($sequencing = $request->get('sequencing', false), function ($q) use($sequencing){
                    if($sequencing == 10){
                        $q->whereNull('sequencing');
                    }else{
                        $q->where('sequencing', $sequencing);
                    }
                })->when($code = $request->get('code', false), function ($q) use($code){
                    $q->where('code', $code);
                })->when($graduation_year = $request->get('graduation_year', false), function ($q) use($graduation_year){
                    $q->where('graduation_year',$graduation_year);
                })->when($selected_grade = $request->get('selected_grade', false), function ($q) use($selected_grade){
                    $q->where('selected_grade', $selected_grade);
                })->when($study_type = $request->get('study_type', false), function ($q) use($study_type){
                    $q->where('study_type', $study_type);
                })->when($gender = $request->get('gender', false), function ($q) use($gender){
                    $q->where('gender', $gender);
                })->when($mobile = $request->get('mobile', false), function ($q) use($mobile){
                    $q->where('mobile', 'like', '%' .$mobile. '%');
                })->when($department = $request->get('department'), function ($q) use($department) {
                    $q->where('lottery_department_id', $department);
                })->when($degree = $request->get('degree'), function ($q) use($degree) {
                    $q->where('lottery_degree_id', $degree);
                })->when($university = $request->get('university'), function ($q) use($university) {
                    $q->where('lottery_university_id', $university);
                })->when($college = $request->get('college'), function ($q) use($college) {
                    $q->where('lottery_college_id', $college);
                })->when($governorate = $request->get('governorate'), function ($q) use($governorate) {
                    $q->where('lottery_governorate_id', $governorate);
                })->when($ministry = $request->get('ministry'), function ($q) use($ministry) {
                    $q->where('lottery_ministry_id', $ministry);
                });

    }

}
