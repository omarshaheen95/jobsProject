<?php

namespace App\Http\Controllers\Manager;

use App\Exports\JobOfferExport;
use App\Exports\UserJobOfferExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\InterviewRequest;
use App\Http\Requests\Manager\JobOfferRequest;
use App\Models\Appreciation;
use App\Models\Degree;
use App\Models\Disability;
use App\Models\Governorate;
use App\Models\JobOffer;
use App\Models\Language;
use App\Models\Ministry;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\Question;
use App\Models\SubDegree;
use App\Models\User;
use App\Models\UserJobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class JobOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jobs offers management');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = JobOffer::query()->with(['position', 'degree'])->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('actions', function ($row) {
                    $show_icon = 'la-users';
                    $show_url = route('manager.job_offer.users', $row->id);
                    $edit_url = route('manager.job_offer.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url', 'show_url', 'show_icon'));
                })->make();
        }
        $title = 'عرض الوظائف';
        $positions = Position::query()->get();
        return view('manager.job_offer.index', compact('title', 'positions'));
    }

    public function create()
    {
        $title = 'إضافة عرض وظيفي';
        $governorates = Governorate::query()->get();
        $qualifications = Qualification::query()->get();
        $positions = Position::query()->get();
        $degrees = Degree::query()->get();
        $languages = Language::query()->get();
        $disabilities = Disability::query()->get();
        $ministries = Ministry::query()->get();
        $questions = Question::query()->get();
        return view('manager.job_offer.edit', compact('title', 'governorates', 'qualifications',
            'positions', 'languages', 'degrees', 'disabilities', 'ministries', 'questions'));
    }

    public function store(JobOfferRequest $request)
    {
        $data = $request->validated();
        $data['gender'] = $request->get('gender') == 0 ? null : $request->get('gender');

        $job_offer = JobOffer::query()->create($data);

        $job_offer->languages()->sync($request->get('languages', []));
        $job_offer->governorates()->sync($request->get('governorates', []));
        $job_offer->disabilities()->sync($request->get('disabilities', []));
        $job_offer->qualifications()->sync($request->get('qualifications', []));
        $job_offer->sub_degrees()->sync($request->get('sub_degrees', []));
        $job_offer->ministries()->sync($request->get('ministries', []));
        $job_offer->questions()->sync($request->get('questions', []));

        return $this->sendResponse(['route' => route('manager.job_offer.index')], 'تم الإضافة بنجاح');
//        return $this->redirectWith(false, 'manager.job_offer.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل عرض وظيفي';
        $job_offer = JobOffer::query()->with(['languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries', 'questions'])->findOrFail($id);
        $job_languages = $job_offer->languages->pluck('id')->values()->all();
        $job_qualifications = $job_offer->qualifications->pluck('id')->values()->all();
        $job_sub_degrees = $job_offer->sub_degrees->pluck('id')->values()->all();
        $job_disabilities = $job_offer->disabilities->pluck('id')->values()->all();
        $job_ministries = $job_offer->ministries->pluck('id')->values()->all();
        $job_governorates = $job_offer->governorates->pluck('id')->values()->all();
        $governorates = Governorate::query()->get();
        $qualifications = Qualification::query()->get();
        $positions = Position::query()->get();
        $degrees = Degree::query()->get();
        $sub_degrees = SubDegree::query()->where('degree_id', $job_offer->degree_id)->get();
        $languages = Language::query()->get();
        $disabilities = Disability::query()->get();
        $ministries = Ministry::query()->get();
        $questions = Question::query()->get();
//        dd($job_offer->questions->pluck('id')->values()->all());


        return view('manager.job_offer.edit', compact('job_offer', 'title', 'governorates', 'qualifications', 'positions', 'languages', 'degrees', 'disabilities', 'ministries', 'sub_degrees',
            'job_disabilities', 'job_governorates', 'job_languages', 'job_qualifications', 'job_sub_degrees', 'job_ministries', 'questions'));
    }

    public function update(JobOfferRequest $request, $id)
    {
        $data = $request->validated();
        $data['gender'] = $request->get('gender') == 0 ? null : $request->get('gender');
        $job_offer = JobOffer::query()->findOrFail($id);
        $job_offer->update($data);

        $job_offer->languages()->sync($request->get('languages', []));
        $job_offer->governorates()->sync($request->get('governorates', []));
        $job_offer->disabilities()->sync($request->get('disabilities', []));
        $job_offer->qualifications()->sync($request->get('qualifications', []));
        $job_offer->sub_degrees()->sync($request->get('sub_degrees', []));
        $job_offer->ministries()->sync($request->get('ministries', []));
        $job_offer->questions()->sync($request->get('questions', []));
        return $this->sendResponse(['route' => route('manager.job_offer.index')], 'تم التعديل بنجاح');
//        return $this->redirectWith(false, 'manager.job_offer.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $job_offer = JobOffer::query()->findOrFail($id);
        $job_offer->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }

    public function usersJobOffers(Request $request, $id)
    {
        if ($request->ajax()) {
            $rows = UserJobOffer::query()->has('user')->where('job_offer_id', $id)
                ->with(['user', 'user.userInfo', 'interview'])->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('uid', function ($row) {
                    return $row->user->userInfo->uid;
                })
                ->addColumn('gender', function ($row) {
                    return $row->user->userInfo->gender_name;
                })
                ->addColumn('governorate', function ($row) {
                    return $row->user->userInfo->governorate->name;
                })
                ->addColumn('mobile', function ($row) {
                    return $row->user->userInfo->mobile;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('status', function ($row) {
                    return $row->status_name;
                })
                ->addColumn('interview', function ($row) {
                    if ($row->status == 'approve') {
                        return $row->interview ? 'تم التحديد' : 'لم يتم التحديد';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('actions', function ($row) {
                    $show_icon = 'la-users';
                    $test_icon = 'la-list';
                    $show_url = route('manager.user.show', $row->user_id);
                    $edit_url = route('manager.job_offer.status', $row->id);
                    $test_url = route('manager.job_offer.test', $row->id);
                    if (!is_null($row->total_mark))
                    {
                        return view('manager.settings.actions_buttons', compact('row', 'show_url', 'edit_url', 'test_icon', 'test_url'));
                    }else{
                        return view('manager.settings.actions_buttons', compact('row', 'show_url', 'edit_url'));
                    }

                })->make();
        }
        $title = 'عرض المتقدمين';
        $job_offer = JobOffer::query()->findOrFail($id);
        $governorates = Governorate::query()->get();
        return view('manager.job_offer.users', compact('title', 'job_offer', 'governorates'));
    }

    public function deleteUserJobOffer($id)
    {
        $job_offer = UserJobOffer::query()->findOrFail($id);
        $job_offer->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }

    public function userJobOfferStatus($id)
    {
        $job_offer = UserJobOffer::query()->with(['jobOffer', 'interview'])->findOrFail($id);
        $title = 'حالة الطلب';
        return view('manager.job_offer.status', compact('job_offer', 'title'));
    }

    public function userJobOfferTest($id)
    {
        $job_offer = UserJobOffer::query()->with(['jobOffer', 'jobOffer.questions'])->findOrFail($id);
        $title = 'نتيجة بيانات تقديم الطلب';
        return view('manager.job_offer.test', compact('job_offer', 'title'));
    }

    public function updateUserJobOfferStatus(InterviewRequest $request, $id)
    {
        $job_offer = UserJobOffer::query()->findOrFail($id);
        $job_offer->update([
            'status' => $request->get('status', 'pending'),
            'manager_id' => Auth::guard('manager')->id(),
            'note' => $request->get('note', 'null'),
        ]);
        if ($request->get('interview_place', false) && $request->get('interview_date', false)) {
            $job_offer->interview()->updateOrCreate([
                'interview_date' => $request->get('interview_date'),
                'interview_place' => $request->get('interview_place'),
            ]);
        }else{
            optional($job_offer->interview)->delete();
        }
        return redirect()->route('manager.job_offer.users', $job_offer->id)->with('m-class', 'success')->with('message', 'تم الحفظ بنجاح');
    }

    public function exportUserJobOfferExcel(Request $request, $id)
    {
        $title = JobOffer::query()->findOrFail($id)->name;
        $name = 'المتقدمين لعرض  - '.$title . '.xlsx';
        return (new UserJobOfferExport($request, $id))
            ->download($name);
    }

    public function exportJobOfferExcel(Request $request)
    {
        $name = 'العروض الوظیفیة.xlsx';
        return (new JobOfferExport($request))
            ->download($name);
    }

}
