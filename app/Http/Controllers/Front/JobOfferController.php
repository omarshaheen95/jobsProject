<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Interview;
use App\Models\JobOffer;
use App\Models\Ministry;
use App\Models\Position;
use App\Models\Qualification;
use App\Models\UserJobOffer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobOfferController extends Controller
{
    public function allJobOffers(Request $request)
    {
        $name = $request->get('name', false);
        $ministries = $request->get('ministry', []);
        $qualifications = $request->get('qualification', []);
        $degrees = $request->get('degree', []);
        $positions = $request->get('position', []);

        $job_offers = JobOffer::query()->with(['position', 'degree', 'media'])
//            ->where('publish_at', '>=', now())
            ->when($name, function (Builder $query) use ($name) {
                $query->where(function(Builder $query) use($name){
                    $query->where('name', 'like', "%$name%")
                        ->orWhere('tags', 'like', "%$name%");
                });
            })
            ->when(count($ministries), function (Builder $query) use ($ministries) {
                $query->whereHas('ministries', function (Builder $q) use ($ministries){
                    $q->whereIn('ministry_id', $ministries);
                } );
            })
            ->when(count($qualifications), function (Builder $query) use ($qualifications) {
                $query->whereHas('qualifications', function (Builder $q) use ($qualifications){
                    $q->whereIn('qualification_id', $qualifications);
                } );
            })
            ->when(count($degrees), function (Builder $query) use ($degrees) {
                $query->whereHas('degree', function (Builder $q) use ($degrees){
                    $q->whereIn('id', $degrees);
                } );
            })
            ->when(count($positions), function (Builder $query) use ($positions) {
                $query->whereHas('position', function (Builder $q) use ($positions){
                    $q->whereIn('id', $positions);
                } );
            })
            ->latest()->paginate(10);


        if ($request->ajax()) {
            if ($request->ajax()) {
                $job_offers_view = view('website.job_offer.load_more', compact('job_offers'))->render();
                return $this->sendResponse(['html' => $job_offers_view, 'paginate' => paginate($job_offers)]);
            }
        }
        $title = 'أخر الوظائف';

        $ministries = Ministry::query()->withCount(['jobOffers' => function ($query) {
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();

        $qualifications = Qualification::query()->withCount(['jobOffers' => function ($query) {
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();


        $degrees = Degree::query()->withCount(['job_offers' => function ($query) {
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();



//        dd($job_offers);

        return view('website.job_offer.all', compact('job_offers', 'title', 'ministries', 'degrees', 'positions', 'qualifications'));
    }

    public function showJobOffer($slug)
    {
        $user = Auth::guard('web')->user();
//        $user->jobOffers()->where('job_offer_id', $id)->first();
        $job_offer = JobOffer::query()
            ->withCount('questions')
            ->with(['media', 'position', 'degree' ,'languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries'])
            ->where('slug', $slug)
            ->firstOrFail();
        $title = $job_offer->name;
        return view('website.job_offer.show', compact('title', 'job_offer',));
    }

    public function applyJobOffer(Request $request, $id)
    {
        $user = Auth::guard('web')->user();
        $job_offer = JobOffer::query()->findOrFail($id);

        if(!$user->userInfo)
        {
            return redirect()->back()->with('message', 'لا يمكن التقديم على الوظيفة حتى يتم اكمال الملف الشخصي')->with('m-class', 'error');
        }

        if($user->jobOffers()->where('job_offer_id', $id)->first())
        {
            return redirect()->back()->with('message', 'تم التقديم على هذا الطلب مسبقا')->with('m-class', 'error');
        }

        UserJobOffer::query()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'job_offer_id' => $job_offer->id,
        ]);


        return redirect()->back()->with('message', 'تم القديم على الطلب بنجاح')->with('m-class', 'success');
    }

    public function archiveJobOffers()
    {
        $title = 'طلبات التوظيف';
        $user = Auth::guard('web')->user();
        $job_offers = $user->jobOffers()->orderBy('user_job_offers.created_at', 'desc')->get();
        return view('website.profile.archive', compact('user', 'job_offers', 'title'));
    }

    public function interviews()
    {
        $title = 'مقابلاتي';
        $user = Auth::guard('web')->user();
        $interviews = Interview::query()
            ->with(['user_job_offer', 'user_job_offer.jobOffer'])
            ->whereHas('user_job_offer', function(Builder $query) use ($user){
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();
        return view('website.profile.interviews', compact('user', 'interviews', 'title'));
    }

    public function questionsJobOffers($slug)
    {
        $user = Auth::guard('web')->user();
//        $user->jobOffers()->where('job_offer_id', $id)->first();
        $job_offer = JobOffer::query()
            ->with(['questions', 'questions.options'])
            ->with(['media', 'position', 'degree' ,'languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries'])
            ->where('slug', $slug)
            ->firstOrFail();
        $title = $job_offer->name;
        if($user->jobOffers()->where('job_offer_id', $job_offer->id)->first())
        {
            return redirect()->back()->with('message', 'تم التقديم على هذا الطلب مسبقا')->with('m-class', 'error');
        }

        return view('website.job_offer.questions', compact('job_offer', 'title'));



    }
}
