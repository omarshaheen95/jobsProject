@extends('layouts.container')
@section('content')
    <!-- Start Topics -->
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 class="title">{{$page->title}}</h2>
                        <p class="info">{{$page->sub_title}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="about-box">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Topics -->
@endsection
