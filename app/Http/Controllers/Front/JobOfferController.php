<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\JobOffer;
use App\Models\Ministry;
use App\Models\Position;
use App\Models\Qualification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
                $query->where('name', 'like', "%$name%");
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
            ->latest()->paginate(2);


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

        $positions = Position::query()->withCount(['job_offers' => function ($query) {
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();


//        dd($job_offers);

        return view('website.job_offer.all', compact('job_offers', 'title', 'ministries', 'degrees', 'positions', 'qualifications'));
    }

    public function showJobOffer($slug)
    {

        $job_offer = JobOffer::query()
            ->with(['languages', 'governorates', 'disabilities', 'qualifications', 'sub_degrees', 'ministries'])
            ->where('slug', $slug)
            ->firstOrFail();
        $title = $job_offer->name;
        $last_job_offer = JobOffer::query()->with(['media'])->whereNotIn('id', [$job_offer->id])->inRandomOrder()->latest()->limit(3)->get();

        return view('website.job_offer.show', compact('title', 'job_offer', 'last_job_offer'));
    }
}
