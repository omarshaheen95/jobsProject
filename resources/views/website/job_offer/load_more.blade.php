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
