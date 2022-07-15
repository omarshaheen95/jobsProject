@extends('layouts.container')

@section('content')
    <!-- Start Topics -->
    <section class="inner-section profile-section">
        <div class="container">
            <form action="{{route('applyJobOffer', $job_offer->id)}}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 class="sub-title">يرجى الإجابة على الأسئلة والمتطلبات التالية : </h2>
                        </div>
                    </div>
                    @php
                    $counter = 1;
                    @endphp
                    @foreach($job_offer->questions as $question)
                        @if($question->type == 'checkbox')
                            <div class="col-xl-12">
                                <div class="question-box">
                                    <h2 class="number text-theme">سؤال {{$counter}} :</h2>
                                    <h3 class="title"> {{$question->question}} </h3>
                                    <div class="answers">
                                        @foreach($question->options as $key => $option)
                                        <div class="answer-box">
                                            <input id="answer-1-{{$key}}-{{$question->id}}-{{$option->id}}" name="checked[{{$question->id}}][]" value="{{$option->id}}" type="checkbox">
                                            <label for="answer-1-{{$key}}-{{$question->id}}-{{$option->id}}" class="answer-label">{{$option->option}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif($question->type == 'radio')
                            <div class="col-xl-12">
                                <div class="question-box">
                                    <h2 class="number text-theme">سؤال {{$counter}} :</h2>
                                    <h3 class="title"> {{$question->question}} </h3>
                                    <div class="answers">
                                        @foreach($question->options as $key => $option)
                                            <div class="answer-box">
                                                <input id="answer-1-{{$key}}-{{$question->id}}-{{$option->id}}" name="radio[{{$question->id}}]" value="{{$option->id}}" type="radio">
                                                <label for="answer-1-{{$key}}-{{$question->id}}-{{$option->id}}" class="answer-label">{{$option->option}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif($question->type == 'writing')
                            <div class="col-xl-12">
                                <div class="question-box">
                                    <h2 class="number text-theme">سؤال {{$counter}} :</h2>
                                    <h3 class="title"> {{$question->question}} </h3>
                                    <textarea class="form-control" name="writing[{{$question->id}}]" rows="10" placeholder=" اكتب الاجابة هنا ..."
                                              required></textarea>
                                </div>
                            </div>
                        @elseif($question->type == 'file')
                            <div class="col-xl-12">
                                <div class="question-box">
                                    <h2 class="number text-theme">سؤال {{$counter}} :</h2>
                                    <h3 class="title"> {{$question->question}} </h3>
                                    <input class="form-control" name="attachment[{{$question->id}}]" type="file"
                                              required>
                                </div>
                            </div>
                        @endif
                            @php
                                $counter ++;
                            @endphp
                    @endforeach
                    <div class="col-xl-12">
                        <div class="text-end">
                            <button type="submit" class="btn btn-theme btn-submit px-5">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                      aria-hidden="true"></span>
                                حفظ
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- End Topics -->
@endsection
@section('script')
@endsection
