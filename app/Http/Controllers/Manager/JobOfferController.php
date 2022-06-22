<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\JobOfferRequest;
use App\Models\Degree;
use App\Models\Disability;
use App\Models\Governorate;
use App\Models\JobOffer;
use App\Models\Language;
use App\Models\Ministry;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\SubDegree;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = JobOffer::query()->with(['position', 'degree'])->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.job_offer.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الوظائف';
        return view('manager.job_offer.index', compact('title'));
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
        return view('manager.job_offer.edit', compact('title', 'governorates', 'qualifications', 'positions', 'languages', 'degrees', 'disabilities', 'ministries'));
    }

    public function store(JobOfferRequest $request)
    {
        $data = $request->validated();
        $data['gender'] = $request->get('gender') == 0 ? null:$request->get('gender');

        $job_offer = JobOffer::query()->create($data);

        $job_offer->languages()->sync($request->get('languages', []));
        $job_offer->governorates()->sync($request->get('governorates', []));
        $job_offer->disabilities()->sync($request->get('disabilities', []));
        $job_offer->qualifications()->sync($request->get('qualifications', []));
        $job_offer->sub_degrees()->sync($request->get('sub_degrees', []));
        $job_offer->ministries()->sync($request->get('ministries', []));

        return $this->sendResponse(['route' => route('manager.job_offer.index')],'تم الإضافة بنجاح');
//        return $this->redirectWith(false, 'manager.job_offer.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل عرض وظيفي';
        $job_offer = JobOffer::query()->with(['languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries'])->findOrFail($id);
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
        $sub_degrees = SubDegree::query()->get();
        $languages = Language::query()->get();
        $disabilities = Disability::query()->get();
        $ministries = Ministry::query()->get();

        return view('manager.job_offer.edit', compact('job_offer','title', 'governorates', 'qualifications', 'positions', 'languages', 'degrees', 'disabilities', 'ministries', 'sub_degrees',
        'job_disabilities', 'job_governorates', 'job_languages', 'job_qualifications', 'job_sub_degrees', 'job_ministries'));
    }
    public function update(JobOfferRequest $request, $id)
    {
        $data = $request->validated();
        $data['gender'] = $request->get('gender') == 0 ? null:$request->get('gender');
        $job_offer = JobOffer::query()->findOrFail($id);
        $job_offer->update($data);

        $job_offer->languages()->sync($request->get('languages', []));
        $job_offer->governorates()->sync($request->get('governorates', []));
        $job_offer->disabilities()->sync($request->get('disabilities', []));
        $job_offer->qualifications()->sync($request->get('qualifications', []));
        $job_offer->sub_degrees()->sync($request->get('sub_degrees', []));
        $job_offer->ministries()->sync($request->get('ministries', []));
        return $this->sendResponse(['route' => route('manager.job_offer.index')], 'تم التعديل بنجاح');
//        return $this->redirectWith(false, 'manager.job_offer.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $job_offer = JobOffer::query()->findOrFail($id);
        $job_offer->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
