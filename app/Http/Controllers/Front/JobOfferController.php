<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\JobOffer;
use App\Models\Ministry;
use App\Models\Position;
use App\Models\Qualification;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function allJobOffers(Request $request)
    {
        if ($request->ajax())
        {
            if ($request->ajax()) {
                $job_offers = JobOffer::query()->with(['media'])->latest()->paginate(2);
                $job_offers_view = view('website.job_offer.load_more', compact('job_offers'))->render();
                return $this->sendResponse(['html' => $job_offers_view, 'paginate' => paginate($job_offers)]);
            }
        }
        $title = 'أخر الوظائف';
        $job_offers = JobOffer::query()->with(['position', 'degree'])->with(['media'])
//            ->where('publish_at', '>=', now())
            ->latest()->paginate(2);

        $ministries = Ministry::query()->withCount(['jobOffers' => function($query){
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();

        $qualifications = Qualification::query()->withCount(['jobOffers' => function($query){
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();


        $degrees = Degree::query()->withCount(['job_offers' => function($query){
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();

        $positions = Position::query()->withCount(['job_offers' => function($query){
            //$query->where('publish_at', '>=', now());
        }])->orderByDesc('job_offers_count')->get();


//        dd($ministries);

        return view('website.job_offer.all', compact('job_offers', 'title', 'ministries', 'degrees', 'positions', 'qualifications'));
    }
}
