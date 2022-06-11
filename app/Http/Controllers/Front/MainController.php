<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Degree;
use App\Models\Governorate;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function welcome(Request $request)
    {
        $title = 'الرئيسية';
        $special_news = News::query()->where('special', 1)->latest()->limit(5)->get();
        $degrees = Degree::query()->withCount(['job_offers'])->orderByDesc('job_offers_count')->limit(5)->get();
        $last_news = News::query()->with(['media'])->latest()->limit(3)->get();
        return view('welcome', compact('title', 'special_news', 'degrees', 'last_news'));
    }

    public function allNews(Request $request)
    {
        $title = 'الأخبار';
        if ($request->ajax()) {
            $last_news = News::query()->with(['media'])->latest()->paginate(9);
            $news_view = view('website.news.load_more', compact('last_news'))->render();
            return $this->sendResponse(['html' => $news_view, 'paginate' => paginate($last_news)]);
        }
        $last_news = News::query()->with(['media'])->latest()->paginate(9);
        return view('website.news.all', compact('title', 'last_news'));
    }

    public function showNews($slug)
    {
        $news = News::query()->where('slug', $slug)->firstOrFail();
        $news->increment('views');
        $title = $news->title;
        $last_news = News::query()->with(['media'])->whereNotIn('id', [$news->id])->inRandomOrder()->latest()->limit(3)->get();

        return view('website.news.show', compact('title', 'news', 'last_news'));
    }

    public function showPage($key)
    {
        $page = Page::query()->where('key', $key)->firstOrFail();
        $title = $page->title;

        return view('website.page', compact('title', 'page'));
    }

    public function contactUs(Request $request)
    {
        $title = 'اتصل بنا';
        $governorates = Governorate::query()->get();
        return view('website.contact_us', compact('title', 'governorates'));
    }

    public function contactUsMessage(Request $request)
    {
        $data = $request->validate([
            'governorate_id' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        ContactUs::query()->create($data);
        return $this->sendResponse(null, 'تم الارسال بنجاح');
    }
}
