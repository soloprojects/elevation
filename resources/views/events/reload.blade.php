<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>View</th>
        <th>Event Title</th>
        <th>Start</th>
        <th>End</th>
        <th>Created by</th>
        <th>Event Type</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Attend</th>
        <th>Manage</th>
        <th>View</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>

            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="readEvent('{{$data->event_title}}','{!!$data->event_desc!!}','event_title_id','event_detail_id','event_modal')">Read Details</a>

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->event_title}}</td>
            <td>{{$data->start_event}}</td>
            <td>{{$data->end_event}}</td>
            <td>
                {{$data->user->name}}
            </td>
            <td>
                {{\App\Helpers\Utility::eventType($data->event_type)}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attend_content','attend_modal','<?php echo url('attend_events_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Attend</a>

            </td>
            @if(Auth::user()->role_id ==  \App\Helpers\Utility::superAdmin || Auth::user()->role_id == \App\Helpers\Utility::admin)
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_events_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Edit</a>

            </td>
            <td><a href="{{route('all_attendees', ['id' => $data->id])}}">View Attendees</a></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>