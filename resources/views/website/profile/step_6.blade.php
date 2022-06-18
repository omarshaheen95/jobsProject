@extends('website.profile.container')
@section('profile_content')
    <div class="table-content form-step-box">
        <div class="head">
            <h3 class="title"> اللغات </h3>
            <a href="#!" class="btn btn-add">
                اضافة
            </a>
        </div>

        <div class="d-none" id="form-content">
            <form action="{{route('user_language.store')}}" method="post" class=" form-collapse" id="form-collapse" novalidate>
                @csrf
                <input type="hidden" class="form-control" id="id" value="0" name="id">
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <div class="form-group">
                            <label for="language_id" class="form-label"> اللغة</label>
                            <select id="language_id" name="language_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر اللغة</option>
                                @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label class="form-label">كيف تقييم نفسك في القراءة في هذه اللغة</label>
                        <div class="stars">
                            <input class="star star-5" id="lane_read_rate-5" type="radio" name="reading_rate" value="5">
                            <div class="invalid-feedback"></div>
                            <label class="star star-5" for="lane_read_rate-5"></label>

                            <input class="star star-4" id="lane_read_rate-4" type="radio" name="reading_rate" value="4">
                            <label class="star star-4" for="lane_read_rate-4"></label>

                            <input class="star star-3" id="lane_read_rate-3" type="radio" name="reading_rate" value="3">
                            <label class="star star-3" for="lane_read_rate-3"></label>

                            <input class="star star-2" id="lane_read_rate-2" type="radio" name="reading_rate" value="2">
                            <label class="star star-2" for="lane_read_rate-2"></label>

                            <input class="star star-1" id="lane_read_rate-1" type="radio" name="reading_rate" value="1">
                            <label class="star star-1" for="lane_read_rate-1"></label>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label class="form-label">كيف تقييم نفسك في الكتابة في هذه اللغة</label>
                        <div class="stars">
                            <input class="star star-5" id="lane_write_rate-5" type="radio" name="writing_rate" value="5">
                            <div class="invalid-feedback"></div>
                            <label class="star star-5" for="lane_write_rate-5"></label>

                            <input class="star star-4" id="lane_write_rate-4" type="radio" name="writing_rate" value="4">
                            <label class="star star-4" for="lane_write_rate-4"></label>

                            <input class="star star-3" id="lane_write_rate-3" type="radio" name="writing_rate" value="3">
                            <label class="star star-3" for="lane_write_rate-3"></label>

                            <input class="star star-2" id="lane_write_rate-2" type="radio" name="writing_rate" value="2">
                            <label class="star star-2" for="lane_write_rate-2"></label>

                            <input class="star star-1" id="lane_write_rate-1" type="radio" name="writing_rate" value="1">
                            <label class="star star-1" for="lane_write_rate-1"></label>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label class="form-label">كيف تقييم نفسك في المحادثة في هذه اللغة</label>
                        <div class="stars">
                            <input class="star star-5" id="lane_speak_rate-5" type="radio" name="conversation_rate" value="5">
                            <div class="invalid-feedback"></div>
                            <label class="star star-5" for="lane_speak_rate-5"></label>

                            <input class="star star-4" id="lane_speak_rate-4" type="radio" name="conversation_rate" value="4">
                            <label class="star star-4" for="lane_speak_rate-4"></label>

                            <input class="star star-3" id="lane_speak_rate-3" type="radio" name="conversation_rate" value="3">
                            <label class="star star-3" for="lane_speak_rate-3"></label>

                            <input class="star star-2" id="lane_speak_rate-2" type="radio" name="conversation_rate" value="2">
                            <label class="star star-2" for="lane_speak_rate-2"></label>

                            <input class="star star-1" id="lane_speak_rate-1" type="radio" name="conversation_rate" value="1">
                            <label class="star star-1" for="lane_speak_rate-1"></label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="text-end">
                            <button type="submit" class="btn btn-theme btn-submit w-100">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                حفظ
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="border my-5">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table" id="table_content">
                <thead>
                <tr>
                    <th>اللغة</th>
                    <th>القراءة</th>
                    <th>الكتابة</th>
                    <th>المحادثة</th>
                    <th>خيارات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user_languages as $u_l)
                <tr id="row_{{$u_l->id}}">
                    <td> {{$u_l->language->name}} </td>
                    <td> {{$u_l->reading_rate}} </td>
                    <td> {{$u_l->writing_rate}} </td>
                    <td> {{$u_l->conversation_rate}} </td>
                    <td>
                        <div class="btn-action btn-edit"
                             data-id="{{$u_l->id}}"
                             data-url="{{route('user_language.store')}}"
                             data-lang_title="{{$u_l->language->name}}"
                             data-language_id="{{$u_l->language_id}}"
                             data-reading_rate="{{$u_l->reading_rate}}"
                             data-writing_rate="{{$u_l->writing_rate}}"
                             data-conversation_rate="{{$u_l->conversation_rate}}"
                        >
                            <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg" width="21.137" height="22" viewBox="0 0 21.137 22">
                                <path id="Path_50197" data-name="Path 50197" d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <path id="Path_50198" data-name="Path 50198" d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="btn-action btn-remove" data-id="{{$u_l->id}}" data-url="{{route('user_language.delete', $u_l->id)}}" data-title=" هل تريد حذف اللغة ؟" data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.224" height="22" viewBox="0 0 19.224 22">
                                <g id="Group_52534" data-name="Group 52534" transform="translate(-30.62)">
                                    <path id="Path_50193" data-name="Path 50193" d="M31.62,5H48.844" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50194" data-name="Path 50194" d="M36.4,5V3a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,38.318,1h3.827a1.88,1.88,0,0,1,1.351.588A2.054,2.054,0,0,1,44.059,3V5ZM46.93,5V19a2.055,2.055,0,0,1-.563,1.412A1.881,1.881,0,0,1,45.016,21H35.447a1.88,1.88,0,0,1-1.351-.588A2.054,2.054,0,0,1,33.534,19V5Z" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50195" data-name="Path 50195" d="M38.318,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50196" data-name="Path 50196" d="M42.146,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between gap-4">
        <a href="{{route('profile.step', 'experiences')}}" class="btn btn-secondary border px-5">
            رجوع
        </a>
        <a href="{{route('profile.step', 'disabilities')}}" class="btn btn-theme px-5">
            التالي
        </a>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('front/js/user_language.js')}}"></script>
@endsection
