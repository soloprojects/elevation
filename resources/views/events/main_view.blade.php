@extends('layouts.layout')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add New Event </h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="start_date" placeholder="Start Date 2021/02/10">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control timepicker" name="start_time" placeholder="Start Time Hr:Mins:Secs">
                                        </div>
                                    </div>
                                </div>
                            </div><hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="end_date" placeholder="end Date 2021/02/12">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control timepicker" name="end_time" placeholder="End Time Hr:Mins:Secs">
                                        </div>
                                    </div>
                                </div>
                            </div><hr/>

                            <div class="row clearfix">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="event_title" placeholder="Event Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="schedule_type" >
                                                <option value="">Schedule Type</option>
                                                @foreach(\App\Helpers\Utility::EVENT_TYPE as $key => $var)
                                                    <option value="{{$key}}">{{$var}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" id="details" class="form-control " name="details" placeholder="Details">Enter event details</textarea>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_events'); ?>','reload_data',
                            '<?php echo url('events'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height:450px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_events'); ?>','reload_data',
                            '<?php echo url('events'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="event_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Event Details</h4>
                </div>
                <div class="modal-body" id="" style="height:450px; overflow:scroll;">
                    <h5 id="event_title_id"></h5>
                    <span id="event_detail_id"></span>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="attend_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attend Event</h4>
                </div>
                <div class="modal-body" id="attend_content" >
                    
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Decline</button>
                    <button type="button"  onclick="submitMediaForm('attend_modal','attendMainForm','<?php echo url('attend_events'); ?>','reload_data',
                        '<?php echo url('events'); ?>','<?php echo csrf_token(); ?>')"
                        class="btn btn-info waves-effect">
                    Attend this event
                </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Events
                    </h2>
                    @if(Auth::user()->role_id ==  \App\Helpers\Utility::superAdmin || Auth::user()->role_id == \App\Helpers\Utility::admin)
                    <ul class="header-dropdown m-r--5">

                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('events'); ?>',
                                    '<?php echo url('delete_events'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                           
                        </li>

                    </ul>
                    @endif
                </div>
                <div class="body table-responsive tbl_scroll" id="reload_data">
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

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    //READ NEWS
    function readEvent(title,detail,titleId,detailId,modalId){
        $('#'+modalId).modal('show');
        $('#'+titleId).html(title);
        $('#'+detailId).html(detail);

    }

   
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection