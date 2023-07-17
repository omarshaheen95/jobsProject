<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\Lottery\Applicant;
use App\Models\Lottery\Grade;
use App\Models\Lottery\Lottery;
use App\Models\Lottery\LotteryCollege;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryMinistry;
use App\Models\News;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserJobOffer;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general settings management')->only(['viewSettings', 'settings']);
    }

//    public function home()
//    {
//        $news = News::query()->count();
//        $users = User::query()->count();
//        $job_offers = JobOffer::query()->count();
//        $users_job_offers = UserJobOffer::query()->count();
//
//        $users_date = User::query()->groupBy('date')->orderBy('date', 'DESC')->whereMonth('created_at', now())
//            ->whereYear('created_at', now())
//            ->get(array(
//                DB::raw('Date(created_at) as date'),
//                DB::raw('COUNT(*) as counts')
//            ));
//        $users_job_offers_chart = UserJobOffer::query()->groupBy('date')->orderBy('date', 'DESC')->whereMonth('created_at', now())
//            ->whereYear('created_at', now())
//            ->get(array(
//                DB::raw('Date(created_at) as date'),
//                DB::raw('COUNT(*) as counts')
//            ));
//
//        return view('manager.home', compact('news', 'users', 'job_offers', 'users_job_offers', 'users_date', 'users_job_offers_chart'));
//    }
    public function home()
    {
        $data['applicants'] = Applicant::query()->count();
        $data['applicants_available'] = Applicant::query()->whereNull('lottery_ministry_id')->count();
        $data['applicants_used'] = Applicant::query()->whereNotNull('lottery_ministry_id')->count();
        $data['applicants_top'] = Applicant::query()
            ->whereRelation('lottery_degree', 'name', 'like', '%بكالوريوس%')
            ->where('sequencing', 1)->count();

        $data['applicants_need'] = Grade::query()->sum('total_required');

        $data['grades'] = Grade::query()
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->get()->count();

        $data['total_grades_discrimination'] = Grade::query()
            ->whereRelation('lottery_ministry', 'discrimination', 1)
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->get()->sum('sum_total_required');
        $data['total_grades_general'] = Grade::query()
            ->whereRelation('lottery_ministry', 'discrimination', 0)
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->get()->sum('sum_total_required');

        $data['departments'] = LotteryDepartment::query()->where('governor', 0)->count();
        $data['governor_departments'] = LotteryDepartment::query()->where('governor', 1)->count();
        $data['ministries'] = LotteryMinistry::query()->count();
        $data['ministries_discrimination'] = LotteryMinistry::query()->where('discrimination', 1)->count();

        return view('manager.home_lottery', compact('data'));
    }

    public function viewSettings()
    {
        $title = 'الإعدادات العامة';
        $settings = Setting::query()->get();
        return view('manager.settings.general', compact('title', 'settings'));
    }

    public function settings(Request $request, Factory $cache)
    {
        $settings_data = $request->validate([
            'settings' => 'required|array',
        ]);


        foreach ($settings_data['settings'] as $key => $val) {
            $setting = Setting::query()->where('key', $key)->first();
            if ($setting) {
                $setting->update([
                    'value' => $val,
                ]);
            }
        }
        // When the settings have been updated, clear the cache for the key 'settings'
        $settings = Setting::query()->get();

        $cache->forget('settings');
        $settings = $cache->remember('settings', 60, function () use ($settings) {
            // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
            return $settings->pluck('value', 'key')->all();
        });
        $message = t('settings updated successfully');
        config()->set('settings', $settings);
        Artisan::call('config:cache');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return $this->redirectWith(true, null, 'تم التحديث بنجاح');
    }

    public function collegeByUniversity(Request $request, $id)
    {
        $rows = LotteryCollege::query()->where('lottery_university_id', $id)->get();
        $html = '<option selected value="">الكل</option>';
        foreach ($rows as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        return response()->json(['html' => $html]);
    }


    public function departmentByGrade(Request $request, $id)
    {
        $governor = $request->get('governor', false);
        $rows = LotteryDepartment::query()
            ->whereHas('grades', function(Builder $query) use($id){
                $query->where('grade_required', $id);
            })
            ->when($governor == 1, function($query){
                $query->where('governor', 1);
            })
            ->when(!$governor, function($query){
                $query->where('governor', 0);
            })
            ->get();

        $html = '<option selected value="">اختر قسم</option>';
        foreach ($rows as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function generalDepartmentByGrade(Request $request, $id)
    {
        $rows = LotteryDepartment::query()
            ->whereHas('grades', function(Builder $query) use($id){
                $query->where('grade_required', $id);
            })
            ->get();

        $html = '<option selected value="">اختر قسم</option>';
        foreach ($rows as $row) {
            $html .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        return response()->json(['html' => $html]);
    }


    public function ministriesByDepartment(Request $request)
    {
        $department = $request->get('department', false);
        $selected_grade = $request->get('selected_grade', false);

        $ministries = Grade::query()
            ->with(['lottery_ministry'])
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->where('discrimination', 0);
            })
            ->where('lottery_department_id', $department)
            ->where('grade_required', $selected_grade)
            ->select(['lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->groupBy(['lottery_ministry_id', 'grade_required'])
            ->having('sum_total_required', '>', 1)
            ->get();

        $sum_ministries_required = Grade::query()
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->where('discrimination', 0);
            })
            ->where('lottery_department_id', $department)
            ->where('grade_required', $selected_grade)
            ->sum('total_required');


        $applicants = Applicant::query()
            ->whereNull('lottery_ministry_id')
            ->where('lottery_department_id', $department)
            ->where('selected_grade', $selected_grade)
            ->inRandomOrder()
            ->inRandomOrder()
            ->inRandomOrder()
            ->get();

        $applicants_count = $applicants->count();

        if ($applicants_count < $sum_ministries_required) {
            $sub_applicants_ratio = ($sum_ministries_required - $applicants_count) / $sum_ministries_required;
        } else {
            $sub_applicants_ratio = 1;
        }

        foreach ($ministries as $key => $ministry) {
            $ministry->total_completed = Applicant::query()
                ->where('lottery_ministry_id', $ministry->lottery_ministry_id)
                ->where('lottery_department_id', $department)
                ->where('selected_grade', $selected_grade)
                ->count();

            $ministry->total_required = $ministry->sum_total_required - $ministry->total_completed;

            if ($sub_applicants_ratio < 1) {
                $ministry->total_expected = (int)(($ministry->total_required / $sum_ministries_required) * $applicants_count);
            } else {
                $ministry->total_expected = $ministry->total_required;
            }

            if ($ministry->total_required == 0) {
                $ministries->forget($key);
            }
        }


        return $this->sendResponse([
            'sum_ministries_required' => $sum_ministries_required,
            'ministries' => $ministries,
            'applicants' => $applicants,
            'available_applicants' => $applicants_count,
        ]);

    }

}
