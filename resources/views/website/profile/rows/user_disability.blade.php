<tr id="row_{{$u_d->id}}">
    <td> {{$u_d->disability->name}} </td>
    <td> {{$u_d->disability_rate}} </td>
    <td> {{$u_d->enterprise_follow_up}} </td>
    <td>
        <div class="btn-action btn-edit"
             data-id="{{$u_d->id}}"
             data-url="{{route('user_disability.store')}}"
             data-disablity="{{$u_d->disability->name}}"
             data-disablity_id="{{$u_d->disability_id}}"
             data-disability_rate="{{$u_d->disability_rate}}"
             data-enterprise_follow_up="{{$u_d->enterprise_follow_up}}"
        >
            <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg" width="21.137" height="22" viewBox="0 0 21.137 22">
                <path id="Path_50197" data-name="Path 50197" d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <path id="Path_50198" data-name="Path 50198" d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </div>
        <div class="btn-action btn-remove" data-id="{{$u_d->id}}" data-url="{{route('user_disability.delete', $u_d->id)}}" data-title=" هل تريد حذف الاعاقة ؟" data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">
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
