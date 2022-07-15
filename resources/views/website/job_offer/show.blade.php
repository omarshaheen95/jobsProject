@extends('layouts.container')

@section('content')
    <!-- Start Topics -->
    <section class="inner-section">
        <div class="container">


            <div class="row">
                <div class="col-12">
                    <div class="grid-career-box">
                        <div class="pic">
                            <img src="{{asset('front/img/main-logo.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h2 class="title">{{$job_offer->name}} </h2>
                            <h3 class="company-name">رقم الإعلان : #{{$job_offer->job_uuid}}</h3>
                            <p class="description">{{$job_offer->content}} </p>
                            <div class="action">
                                <ul class="nav nav-tags">
                                    <li class="nav-item">
                                        <a href="#!" class="nav-link">{{$job_offer->degree->name}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#!" class="nav-link">العنوان الوظيفي
                                            : {{$job_offer->position->name}}</a>
                                    </li>
                                </ul>
                                @auth
                                    @if(auth()->user()->jobOffers()->where('job_offer_id', $job_offer->id)->first())
                                        <button disabled  class="btn btn-outline-theme btn-order">
                                            تم التقديم </button>
                                        @else
                                        <a href="#career-modal" data-bs-toggle="modal" class="btn btn-outline-theme btn-order">
                                            طلب تقديم </a>
                                        @endif

                                    @else
                                    <a href="{{route('login')}}" class="btn btn-outline-theme btn-order">
                                        طلب تقديم </a>
                                @endauth

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="about-box">
                        <h3 class="title">الشروط الوظيفية</h3>
                        <div>
                            {!! $job_offer->functional_terms !!}
                        </div>
                    </div>
                    <div class="about-box mt-2">
                        <h3 class="title">المهام الوظيفية</h3>
                        <div>
                            {!! $job_offer->functional_tasks !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-box">
                        <h3 class="title">تفاصيل الوظيفة</h3>
                        <table class="table  table-career-content">
                            <tr>
                                <td>المؤهلات</td>
                                <th>
                                    @if(!$job_offer->qualifications->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->qualifications as $qualification)
                                            {{$qualification->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>التخصصات الفرعية</td>
                                <th>
                                    @if(!$job_offer->sub_degrees->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->sub_degrees as $sub_degree)
                                            {{$sub_degree->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>الوزارات</td>
                                <th>
                                    @if(!$job_offer->ministries->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->ministries as $ministry)
                                            {{$ministry->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>المحافظات</td>
                                <th>
                                    @if(!$job_offer->governorates->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->governorates as $governorate)
                                            {{$governorate->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>اللغات</td>
                                <th>
                                    @if(!$job_offer->languages->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->languages as $language)
                                            {{$language->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>الوضع الصحي</td>
                                <th>
                                    @if(!$job_offer->disabilities->count())
                                        الكل
                                    @else
                                        @foreach($job_offer->disabilities as $disability)
                                            {{$disability->name}}
                                            @if(!$loop->last)
                                                -
                                            @endif
                                        @endforeach
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>الجنس</td>
                                <th>
                                    @if($job_offer->gender == 1)
                                        ذكور
                                    @elseif($job_offer->gender == 2)
                                        إناث
                                    @else
                                        الكل
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>فئة ذوي الأسرى</td>
                                <th>
                                    @if($job_offer->family_of_prisoners == 1)
                                        نعم
                                    @elseif($job_offer->family_of_prisoners == 2)
                                        لا
                                    @else
                                        الكل
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>فئة ذوي الحرجى</td>
                                <th>
                                    @if($job_offer->injured_people == 1)
                                        نعم
                                    @elseif($job_offer->injured_people == 2)
                                        لا
                                    @else
                                        الكل
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>فئة ذوي الشهداء</td>
                                <th>
                                    @if($job_offer->family_of_martyrs == 1)
                                        نعم
                                    @elseif($job_offer->family_of_martyrs == 2)
                                        لا
                                    @else
                                        الكل
                                    @endif
                                </th>
                            </tr>

                        </table>
                        <div class="share-section flex-column align-items-start mb-0">
                            <h4 class="title"> شارك الوظيفة </h4>
                            <ul class="nav nav-social-media">
                                <li class="nav-item">
                                    <a data-sharer="facebook" data-title="{{$job_offer->title}}" data-url="{{route('job_offers.show', $job_offer->slug)}}" rel="noopener noreferrer" class="nav-link">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-sharer="twitter" data-title="{{$job_offer->title}}" data-url="{{route('job_offers.show', $job_offer->slug)}}" rel="noopener noreferrer" class="nav-link">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-sharer="linkedin" data-title="{{$job_offer->title}}" data-url="{{route('job_offers.show', $job_offer->slug)}}" rel="noopener noreferrer" class="nav-link">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a data-sharer="whatsapp" data-title="{{$job_offer->title}}" data-url="{{route('job_offers.show', $job_offer->slug)}}" rel="noopener noreferrer" class="nav-link">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Topics -->
    <!-- career-modal -->
    <div class="modal fade" id="career-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @if($job_offer->questions_count)
                    <div class="modal-box">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="pic">
                            <img src="{{asset('front/img/order-1.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h2 class="title"> للتقدم على هذه الوظيفة يجب عليك اكمال الطلب و البيانات التالية </h2>
                            <a href="{{route('job_offers.questions', $job_offer->slug)}}" class="btn btn-theme w-100"> استمرار </a>
                        </div>
                    </div>
                    @else
                    <div class="modal-box">
                        <div class="pic">
                            <img src="{{asset('front/img/order-2.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h2 class="title"> أنت الان على وشك التقديم على وظيفة </h2>
                            <p class="info"> بالضغط على استمرار أنت تقر وتتعهد أن المعلومات المقدمة صحيحة </p>
                            <form action="{{route('applyJobOffer', $job_offer->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-theme w-100"> استمرار </button>
                            </form>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
@endsection
