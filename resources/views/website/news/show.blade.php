@extends('layouts.container')
@section('content')
    <!-- Start Topics -->
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 class="title">{{$news->title}} </h2>
                        <p class="info text-theme" >{{$news->created_at->translatedFormat('d M Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="topic-box topic-box-view">
                        <div class="pic">
                            <img src="{{asset($news->getFirstMediaUrl('news'))}}" alt="">
                        </div>

                        <div class="content">
                            <h3 >{{$news->sub_title}} </h3>
                            {!! $news->content !!}
                        </div>

                        <div class="share-section">
                            <h4 class="title"> شارك الخبر </h4>
                            <ul class="nav nav-social-media">
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
                                <li class="nav-item">
                                    <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="share-section">
                        <h4 class="title">اخبار مشابهة</h4>
                    </div>
                </div>
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
        </div>
    </section>
    <!-- End Topics -->
@endsection
