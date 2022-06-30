@extends('layouts.container')

@section('content')
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2 class="title">أحدث الوظائف</h2>
                        <p class="info">بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form">
                        <div class="main-fillter-box row">
                            <div class="form-group w-75">
                                <input type="text" name="name" class="form-control" placeholder="عنوان الوظيفة">
                            </div>
                            <div class="form-group w-25">
                                <button type="button" onclick="jobSearch()" data-url="{{route('job_offers.all')}}" id="searchJobs" class="btn btn-theme btn-submit w-100">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                    ابحث عن وظيفة
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="grid-career">
                        @foreach($job_offers as $job_offer)
                        <div class="grid-career-box">
                            <div class="pic">
                                <img src="{{asset('front/img/main-logo.png')}}" alt="">
                            </div>
                            <div class="content">
                                <h2 class="title">{{$job_offer->name}} </h2>
                                <h3 class="company-name">رقم الإعلان :  #{{$job_offer->job_uuid}}</h3>
                                <p class="description">
                                    {{$job_offer->content}}
                                </p>
                                <div class="action">
                                    <ul class="nav nav-tags">
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">{{optional($job_offer->degree)->name}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">العنوان الوظيفي : {{optional($job_offer->position)->name}}</a>
                                        </li>
                                    </ul>
                                    <a href="{{route('job_offers.show', $job_offer->slug)}}" class="btn btn-outline-theme btn-order">  عرض الوظيفة </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-7 col-8">
                            <a href="#!" class="btn btn-theme w-100 mt-4 get-more-career" >
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                جلب المزيد
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="accordion accordion-fillter" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fillter-1" aria-expanded="true" aria-controls="collapseOne">
                                    الوزارة او الجهة
                                </button>
                            </h2>
                            <div id="fillter-1" class="accordion-collapse collapse ">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($ministries as $ministry)
                                        <div class="form-check">
                                            <input class="form-check-input" onchange="jobSearch()" type="checkbox" value="{{$ministry->id}}" name="ministry[]" id="option-1-{{$ministry->id}}">
                                            <label class="form-check-label" for="option-1-{{$ministry->id}}">
                                                <span> {{$ministry->name}} </span>
                                                <span> ( {{$ministry->job_offers_count}} )</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fillter-2" aria-expanded="false" aria-controls="fillter-2">
                                    المؤهل
                                </button>
                            </h2>
                            <div id="fillter-2" class="accordion-collapse collapse ">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($qualifications as $qualification)
                                        <div class="form-check">
                                            <input class="form-check-input" onchange="jobSearch()" type="checkbox" value="{{$qualification->id}}" name="qualification[]" id="option-2-{{$qualification->id}}">
                                            <label class="form-check-label" for="option-2-{{$qualification->id}}">
                                                <span> {{$qualification->name}}  </span>
                                                <span> ( {{$qualification->job_offers_count}} )</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fillter-3" aria-expanded="false" aria-controls="fillter-3">
                                    الاختصاص
                                </button>
                            </h2>
                            <div id="fillter-3" class="accordion-collapse collapse ">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($degrees as $degree)
                                        <div class="form-check">
                                            <input class="form-check-input" onchange="jobSearch()" type="checkbox" {{in_array($degree->id, request()->get('degree', [])) ? 'checked':''}} value="{{$degree->id}}" name="degree[]" id="option-3-{{$degree->id}}">
                                            <label class="form-check-label" for="option-3-{{$degree->id}}">
                                                <span> {{$degree->name}}  </span>
                                                <span> ( {{$degree->job_offers_count}} )</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>

    </script>
@endsection
