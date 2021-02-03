@extends('admin.layouts.app')
@section('content')


               
<div class="page-wrapper">
<div class="page-content container-fluid">
                <center>
                        @if(session('success'))
                        <p class="text-success pulse animated">{{ session('success') }}</p>
                        {{ session()->forget('success') }}
                        @elseif(session('failed'))
                        <p class="text-danger pulse animated">{{ session('failed') }}</p>
                        {{ session()->forget('failed') }}
                        @endif
                </center>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Users Roles
                                   
              
                                </h4>
                                <br>
                            <div class="form-group col-lg-4">
                            <label>Select User Type:</label>
                        <select class="form-control" id="user_type_list" onchange='GetUserRoles(this.value)'>
                          @foreach($user_type as $key)
                          <option value="{{$key['id']}}">{{$key['name']}}</option>
                          @endforeach
                      </select>
                            </div>

                               

                                    <form name="userRolesForm" id="userRolesForm">
                                    @csrf

      <div class="user-data">
        

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <!-- <td width="2%">
                                                        <label class="au-checkbox">
                                                            <input type="checkbox">
                                                            <span class="au-checkmark"></span>
                                                        </label>
                                                    </td> -->
                                                    <th width="35%">Modules</th>
                                                    <th width="35%">Sub-Modules</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 14px;" id="user_roleTBody">
                                              <input type="hidden" name="user_type_id" id="user_type_id" value="{{$user_type[0]['id']}}">
                                            @for($i = 0; $i < count($all_modules); $i++)
                                                <tr id="user_role{{$all_modules[$i]['id']}}">
                                                    <td><li><input onclick='ToggleAllSubModule("{{$all_modules[$i]['id']}}")' id="main_module-cb{{$all_modules[$i]['id']}}"  type="checkbox" name="main_module-cb[]" value="{{$all_modules[$i]['id']}}" <?php if (in_array($all_modules[$i]['id'], $user_role)): ?>
                                                        checked=""
                                                        <?php else: ?>
                                                    <?php endif ?>>&nbsp;&nbsp;&nbsp;{{$all_modules[$i]['name']}}</li></td>
                                                    <td> @for($j = 0 ; $j < count($all_sub_modules[$i]); $j++)  
                                                           <li><input onclick='ToggleMainModule("{{$all_sub_modules[$i][$j]['id']}}","{{$all_modules[$i]['id']}}")' value="{{$all_sub_modules[$i][$j]['id']}}" class="sub_module-cb{{$all_modules[$i]['id']}}" id="sub_module-cb{{$all_sub_modules[$i][$j]['id']}}" type="checkbox" name="main_module-cb[]" <?php if (in_array($all_sub_modules[$i][$j]['id'], $user_role)): ?>
                                                        checked=""
                                                    <?php endif ?>>&nbsp;&nbsp;&nbsp;{{$all_sub_modules[$i][$j]['name']}}</li>
                                                       @endfor</td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>

        </div>
                                        <br>
                                        <button class="btn btn-primary" style="float: right; width: 20%;" type="submit">Save</button>
                                        <br>
                                        <br>

        </form>



                            </div>
                        </div>

</div>
</div>

                                                                            

@endsection
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script type="text/javascript">
    function ToggleAllSubModule(id)
   {    
        check = document.getElementById("main_module-cb"+id);

   

    if (check.checked == true) 
    {
        $('.sub_module-cb'+id).each(function() {
                this.checked = true; 
            }); 
    }
    else
    {
        $('.sub_module-cb'+id).each(function() {
                this.checked = false; 
            });   
    }

   }

   function ToggleMainModule(sub_id,main_id)
   {    

        check = document.getElementById("sub_module-cb"+sub_id);

        
        if (check.checked == true) 
        {
            document.getElementById("main_module-cb"+main_id).checked = true;   
        }
        
   }

   function GetUserRoles(val)
   {
      $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-user-roles-AJAX/"+val,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
          
        },
        success: function(data) {
                            $('#LoadingModal').modal('hide');

            $('#user_roleTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
   }











    $(function() {
        $("form[name='userRolesForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
     
    },
    messages: {
     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('userRolesForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/save-roles",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#LoadingModal').modal('show');
                        },
        success: function(data) {
           
                            $('#LoadingModal').modal('hide');

            get_status = data['status'];
            get_msg    = data['msg'];

                            if (get_status == "0") 
                            {

                             document.getElementById('toast').style.visibility = "visible";
                                document.getElementById('toast').className = "alert alert-danger alert-rounded fadeIn animated";
                                document.getElementById('toastMsg').innerHTML = "Failed, Try Again Later";


                                 setTimeout(function() {
                                document.getElementById('toast').className = "alert alert-danger alert-rounded fadeOut animated";

                            }, 5000);

                            }
                            else
                            {
                                document.getElementById('toast').style.visibility = "visible";
                                document.getElementById('toast').className = "alert alert-success alert-rounded fadeIn animated";
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                                document.getElementById('toast').className = "alert alert-success alert-rounded fadeOut animated";

                            }, 5000);


                            }

    }
  });

    }
  });
  });


</script>