<form name="" id="attendMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
   
    <div class="body">    

        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>


