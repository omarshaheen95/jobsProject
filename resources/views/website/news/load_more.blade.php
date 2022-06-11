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
