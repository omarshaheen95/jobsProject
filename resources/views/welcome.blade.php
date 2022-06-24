@extends('layouts.container')

@section('content')
    <!-- Start Header -->
    <header class="header">
        <div class="share-list">
            <h2 class="title"> <span>شـــارك</span> </h2>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="owl-header-slider owl-carousel owl-theme" id="owl-header">
            @foreach($special_news as $news)
            <div class="owl-slider-box" style="background-image: url({{asset('front/img/bg-header.png')}});">
                <div class="owl-slider-box-content">
                    <h1 class="title">{{$news->title}}</h1>
                    <p class="description">
                        {{$news->sub_title}}
                    </p>
                    <a href="{{route('news.show', $news->slug)}}" class="btn btn-theme">أكتشف المزيد</a>
                </div>
            </div>
            @endforeach
        </div>
    </header>
    <!-- End Header -->
    <!-- Start Career -->
    <section class="career-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <h2 class="title">ابحث عن وظيفتك المناسبة</h2>
                        <p class="info">بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-career owl-carousel owl-theme" id="owl-career">
                        @foreach($degrees as $degree)
                        <a href="{{route('job_offers.all', ['degree[]' => $degree->id])}}" class="career-box">
                            <div class="content">
                                <h3 class="title">{{$degree->name}}</h3>
{{--                                <p class="info"> بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر </p>--}}
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="career-section career-section-2">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-4 col-lg-5 col-md-6 col-9">
                    <div class="career-logo">
                        <img src="{{asset('front/img/main-logo.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title">
                        <h2 class="title">عن مجلس الخدمة الاتحادي</h2>
                        <p class="info">
                            {{config('settings.INTRODUCTION')}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Career -->
    <!-- Start Topics -->
    <section class="career-section career-section-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="section-title text-center">
                        <h2 class="title">أحدث الاخبار</h2>
                        <p class="info">بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($last_news as $news)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <a href="{{route('news.show', $news->slug)}}" class="topic-box">
                        <div class="pic">
                            <img src="{{asset($news->getFirstMediaUrl('news', 'minImage'))}}" alt="">
                        </div>
                        <div class="content">
                            <h3 class="title">{{$news->title}} </h3>
                            <div class="info">
                                <div class="date">{{$news->created_at->translatedFormat('d M Y')}}</div>
                                <div class="more"> اقرأ المزيد </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-8">
                    <a href="{{route('news.all')}}" class="btn btn-theme w-100 mt-4"> اكتشف المزيد </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Topics -->
@endsection
