@extends('layouts.container')
@section('content')
    <!-- Start Topics -->
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2 class="title">أحدث الاخبار</h2>
                        <p class="info">بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center topics-section">
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
            <div class="row more-topic"></div>
            <div class="row justify-content-center">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-8">
                    <a href="#!" class="btn btn-theme w-100 mt-4 get-more-topic">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                              aria-hidden="true"></span>
                        المزيد
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Topics -->
@endsection
@section('script')
<script>

</script>
@endsection
