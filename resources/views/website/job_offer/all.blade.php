@extends('layouts.container')

@section('content')
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2 class="title">أحدث الوظائف</h2>
                        <p class="info">ينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form">
                        <form action="#!" method="get" class="needs-validation" novalidate>
                            <div class="main-fillter-box ">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="عنوان الوظيفة">
                                </div>
                                <div class="form-group">
                                    <select class="form-control form-select">
                                        <option value="" disabled selected> قسم الوظيفة </option>
                                        <option value="1"> قسم 1</option>
                                        <option value="2"> قسم 2</option>
                                        <option value="3"> قسم 3</option>
                                        <option value="4"> قسم 4</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-theme btn-submit w-100">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                        ابحث عن وظيفة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="grid-career">
                        @foreach($job_offers as $job_offer)
                        <div class="grid-career-box">
                            <div class="pic">
                                <img src="{{asset('front/img/main-logo.png')}}" alt="">
                            </div>
                            <div class="content">
                                <h2 class="title">{{$job_offer->name}} </h2>
                                <h3 class="company-name"> #{{$job_offer->job_uuid}}</h3>
                                <p class="description">
                                    {{$job_offer->content}}
                                </p>
                                <div class="action">
                                    <ul class="nav nav-tags">
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">{{$job_offer->degree->name}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#!" class="nav-link">المسمى الوظيفي : {{$job_offer->position->name}}</a>
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
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#fillter-1" aria-expanded="true" aria-controls="collapseOne">
                                    الوزارة او الجهة
                                </button>
                            </h2>
                            <div id="fillter-1" class="accordion-collapse collapse show show">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($ministries as $ministry)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ministry[]" id="option-1-1">
                                            <label class="form-check-label" for="option-1-1">
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
                            <div id="fillter-2" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($qualifications as $qualification)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="qualification[]" id="option-2-1">
                                            <label class="form-check-label" for="option-2-1">
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
                            <div id="fillter-3" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($degrees as $degree)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="degree[]" id="option-3-1">
                                            <label class="form-check-label" for="option-3-1">
                                                <span> {{$degree->name}}  </span>
                                                <span> ( {{$degree->job_offers_count}} )</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#fillter-4" aria-expanded="false" aria-controls="fillter-4">
                                    الدرجة الوظيفية
                                </button>
                            </h2>
                            <div id="fillter-4" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="option-box">
                                        @foreach($positions as $position)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="position[]" id="option-4-1">
                                            <label class="form-check-label" for="option-4-1">
                                                <span> {{$position->name}} </span>
                                                <span> ( {{$position->job_offers_count}} )</span>
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
