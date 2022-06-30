@extends('manager.layout.container')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @foreach($external_links as $external_link)
                    <li class="nav-item">
                        <a href="{{$external_link->url_link}}" class="nav-link">{{$external_link->name}}</a>
                    </li>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
