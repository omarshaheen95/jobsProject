@extends('layouts.container')
@section('content')
<!-- Start Topics -->
<section class="inner-section profile-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2 class="sub-title"> {{isset($profile_title) ? $profile_title:''}}</h2>
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
                                <a href="{{route('interviews')}}" class="nav-link">
                                                <span class="icon">
                                                    <i class="bi bi-briefcase"></i>
                                                </span>
                                    <span class="text"> مقابلاتي </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('archiveJobOffers')}}" class="nav-link">
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
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-step-card">
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'general')}}" class="nav-link {{isset($step) && $step == 'general' ? 'active':''}} {{$user->userInfo  && $step != 'general' ? 'done':''}}">
                                        <span>البيانات الشخصية</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'qualifications')}}" class="nav-link {{isset($step) && $step == 'qualifications' ? 'active':''}} {{$user->userQualifications()->count() && $step != 'qualifications' ? 'done':''}}">
                                        <span>المؤهلات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'skills')}}" class="nav-link {{isset($step) && $step == 'skills' ? 'active':''}} {{$user->userSkills()->count() && $step != 'skills' ? 'done':''}}">
                                        <span>الخبرات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'courses')}}" class="nav-link {{isset($step) && $step == 'courses' ? 'active':''}} {{$user->userCourses()->count() && $step != 'courses' ? 'done':''}}">
                                        <span>الدورات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'experiences')}}" class="nav-link {{isset($step) && $step == 'experiences' ? 'active':''}} {{$user->userExperiences()->count() && $step != 'experiences' ? 'done':''}}">
                                        <span>المهارات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'languages')}}" class="nav-link {{isset($step) && $step == 'languages' ? 'active':''}} {{$user->userLanguages()->count() && $step != 'languages' ? 'done':''}}">
                                        <span>اللغات</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('profile.step', 'disabilities')}}" class="nav-link {{isset($step) && $step == 'disabilities' ? 'active':''}} {{$user->userDisabilities()->count() && $step != 'disabilities' ? 'done':''}}">
                                        <span>الوضع الصحي</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @yield('profile_content')
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Topics -->
@endsection
