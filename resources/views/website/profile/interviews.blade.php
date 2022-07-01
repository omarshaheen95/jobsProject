@extends('layouts.container')
@section('content')
    <!-- Start Topics -->
    <section class="inner-section profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 class="sub-title"> {{isset($title) ? $title:''}}</h2>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="profile-sidebar">
                        <div class="profile-head">
                            <div class="pic">
                                <img src="{{optional($user->userInfo)->getFirstMediaUrl('users','minImage') ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHfHdfcQ1cDWzgVLJr32Z3mVYq20D6pir7fKupEKB6fhvQWGZ5xVx76ydUx9nQJiJlKL0&usqp=CAU'}}" alt="">
                            </div>
                            <div class="content">
                                <h2 class="username"> {{auth()->user()->name}} </h2>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="text-danger"> تسجيل خروج</a>
                            </div>
                            <a href="{{route('changePassword')}}" class="btn-config">
                                <i class="bi bi-gear"></i>
                            </a>
                            <a href="#profile-list" data-bs-toggle="collapse" class="btn-profile-list d-block d-xl-none">
                                <i class="bi bi-list"></i>
                            </a>
                        </div>
                        <div class="profile-list d-xl-block collapse" id="profile-list">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'general')}}" class="nav-link @if(Route::is('profile.step') ) active @endif">
                                                <span class="icon">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                        <span class="text"> السيرة الذاتية </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('interviews')}}" class="nav-link @if(Route::is('interviews') ) active @endif">
                                                <span class="icon">
                                                    <i class="bi bi-briefcase"></i>
                                                </span>
                                        <span class="text"> مقابلاتي </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('archiveJobOffers')}}" class="nav-link @if(Route::is('archiveJobOffers') ) active @endif">
                                                <span class="icon">
                                                    <i class="bi bi-journals"></i>
                                                </span>
                                        <span class="text"> ارشيف طلبات التوظيف </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="profile-body">
                        <div class="table-content form-step-box">
                            <div class="head">
                                <h3 class="title"> المقابلات </h3>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="table_content">
                                    <thead>
                                    <tr>
                                        <th>العرض الوظيفي</th>
                                        <th>تاريخ المقابلة</th>
                                        <th>مكان المقابلة</th>
                                        <th>معاينة العرض</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($interviews as $interview)
                                    <tr id="row_1">
                                        <td> {{$interview->user_job_offer->jobOffer->name}} </td>
                                        <td> {{$interview->interview_date}} </td>
                                        <td>
                                            {{$interview->interview_place}}
                                        </td>
                                        <td> <a href="{{route('job_offers.show', $interview->user_job_offer->jobOffer->slug)}}">معاينة</a>  </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Topics -->
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
