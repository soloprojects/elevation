<table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
   
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_employee_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Edit</a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>                   
            <a href="#">
                <span class="alert-warning">{{$data->first_name}}</span>
            </a>
        </td>
        <td>                   
            <a href="#">
                <span class="alert-warning">{{$data->last_name}}</span>
            </a>
        </td>
        
        <td>{{$data->userData->email}}</td>
        <td>{{$data->phone}}</td>  
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endforeach
    </tbody>
</table>
<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>

