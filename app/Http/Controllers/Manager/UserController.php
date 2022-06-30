<?php

namespace App\Http\Controllers\Manager;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserDisability;
use App\Models\UserExperience;
use App\Models\UserJobOffer;
use App\Models\UserLanguage;
use App\Models\UserQualification;
use App\Models\UserSkill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = User::query()->with(['userInfo', 'userInfo.governorate'])->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('created_at', function ($row){
                    return $row->created_at->toDateTimeString();
                })
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('uid', function ($row){
                    return optional($row->userInfo)->uid ?? 'غير مسجل';
                })
                ->addColumn('gender', function ($row){
                    return optional($row->userInfo)->gender ?? 'غير مسجل';
                })
                ->addColumn('governorate', function ($row){
                    return optional(optional($row->userInfo)->governorate)->name ?? 'غير مسجل';
                })
                ->addColumn('mobile', function ($row){
                    return optional($row->userInfo)->mobile ?? 'غير مسجل';
                })
                ->addColumn('actions', function ($row){
                    $show_url = route('manager.user.show', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'show_url'));
                })->make();
        }
        $title = 'عرض المستخدمين';
        return view('manager.user.index', compact('title'));
    }

    public function show($id)
    {
        $title = 'عرض بيانات المستخدم';
        $user = User::query()->with(['userInfo', 'userInfo.media', 'userInfo.birthGovernorate',  'userInfo.governorate', ])->findOrFail($id);
        return view('manager.user.show', compact('title', 'user'));
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }

    public function userQualifications($id)
    {
        $rows = UserQualification::query()
            ->where('user_id', $id)
            ->with(['qualification', 'degree', 'sub_degree', 'country', 'appreciation'])
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userSkills($id)
    {
        $rows = UserSkill::query()
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userCourses($id)
    {
        $rows = UserCourse::query()
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userExperiences($id)
    {
        $rows = UserExperience::query()
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('self_rate', function ($row){
                return $row->self_rate . '/5';
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userLanguages($id)
    {
        $rows = UserLanguage::query()
            ->with(['language'])
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('reading_rate', function ($row){
                return $row->reading_rate . '/5';
            })
            ->addColumn('writing_rate', function ($row){
                return $row->writing_rate . '/5';
            })
            ->addColumn('conversation_rate', function ($row){
                return $row->conversation_rate . '/5';
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userDisabilities($id)
    {
        $rows = UserDisability::query()
            ->with(['disability'])
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('disability_rate', function ($row){
                return $row->disability_rate . '%';
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userJobOffers($id)
    {
        $rows = UserJobOffer::query()
            ->has('jobOffer')
            ->with(['jobOffer'])
            ->where('user_id', $id)
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('job_offer', function ($row){
                return optional($row->jobOffer)->name;
            })
            ->addColumn('status', function ($row){
                return $row->status_name;
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function userInterviews($id)
    {
        $rows = Interview::query()
            ->with(['user_job_offer', 'user_job_offer.jobOffer'])
            ->whereHas('user_job_offer', function(Builder $query) use ($id){
                $query->where('user_id', $id);
            })
            ->latest();
        return DataTables::make($rows)
            ->escapeColumns([])
            ->addColumn('created_at', function ($row){
                return $row->created_at->toDateTimeString();
            })
            ->addColumn('job_offer', function ($row){
                return $row->user_job_offer->jobOffer->name;
            })
            ->addColumn('actions', function ($row){
                return '';
            })->make();
    }

    public function exportUserExcel(Request $request)
    {
        return (new UserExport($request))
            ->download('المستخدمين.xlsx');
    }

}
