@isset($show_url)
    <a href="{{$show_url}}" class="btn btn-icon btn-danger "><i class="la la-eye"></i></a>
@endisset

@isset($edit_url)
    <a href="{{$edit_url}}" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a>
@endisset

@isset($row)
<button type="button" data-id="{{$row->id}}" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger">
    <i class="la la-trash"></i>
</button>
@endisset
