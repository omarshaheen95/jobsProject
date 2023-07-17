
@isset($lottery_url)
    <a href="{{$lottery_url}}" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a>
@endisset

@isset($edit_url)
    <a href="{{$edit_url}}" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a>
@endisset

@isset($show_url)
    <a href="{{$show_url}}" class="btn btn-icon btn-danger "><i class="la {{isset($show_icon) ? $show_icon:'la-eye'}}"></i></a>
@endisset
@isset($test_url)
    <a href="{{$test_url}}" class="btn btn-icon btn-danger "><i class="la {{isset($test_icon) ? $test_icon:'la-eye'}}"></i></a>
@endisset

@if(isset($row) && !isset($lottery_url))
<button type="button" data-id="{{$row->id}}" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger">
    <i class="la la-trash"></i>
</button>
@endisset

@isset($status_row)
<button type="button" data-id="{{$row->id}}" data-toggle="modal" data-target="#statusModel" class="statusRecord btn btn-icon btn-danger">
    <i class="la la-refresh"></i>
</button>
@endisset
