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
                                <h4 class="card-title">Users
                                    <div class="columns columns-right btn-group float-right">
                                        <a href="{{route('user-roles')}}" class="btn waves-effect waves-light btn-rounded btn-dark"><i class="mr-2 mdi mdi-view-module"></i> User Roles</a>
                                       <a href="{{route('user-type')}}" class="btn waves-effect waves-light btn-rounded btn-light"><i class="mr-2 mdi mdi-view-module"></i> User Types</a>
                                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-dark" onclick="AddUser()"> Add User <i class="mr-2 mdi mdi-plus-circle"></i></button>

                                    </div>
                                </h4>
                                <br>


                                <div class="table-responsive">
                                    <table class="table dataTablesOptions text-center">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Name</th>
                                                <th width="20%">Email</th>
                                                <th width="20%">User Type</th>
                                                <th width="30%">Action</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody id="userTBody">
                                           @foreach($users as $key)
                                            <tr id="user{{$key['id']}}">
                                                <td  class="text-center">{{$loop->iteration}}</td>
                                                <td>{{$key['name']}}</td>
                                                <td>{{$key['email']}}</td>
                                                <td>{{$key->user_type_name->name}}</td>
                                                
                                                <td>
                                                   
                                                    <button data-toggle="tooltip" id="status-btn-color<?php echo $key['id']?>" 
                                                            title="Block/Unblock User"
                                                        <?php if ($key['is_blocked'] == 0): ?>
                                                            class="btn btn-pinterest"
                                                            <?php else: ?>
                                                            class="btn btn-success"
                                                            <?php endif ?> 
                                                           
                                                             onclick='BlockUnblockUser("<?php echo $key['id']?>")'><i id="status-btn-icon<?php echo $key['id']?>"  
                                                            
                                                            <?php if ($key['is_blocked'] == 0): ?>
                                                                class="fa fa-lock tx-15"
                                                            <?php else: ?>
                                                                class="fa fa-unlock tx-15"
                                                            <?php endif ?>

                                                    ></i></button>&nbsp;&nbsp;&nbsp;
                                                    <a data-toggle="tooltip" data-placement="top" 
                                                        title="Edit User" class="btn btn-info" href="javascript:void(0)" onclick='EditUser("<?php echo $key['id']?>","<?php echo $key['name']?>","<?php echo $key['email']?>","<?php echo $key['user_type']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" 
                                                        title="Delete User" class="btn btn-danger" onclick='DeleteUser("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a>
                                                    
                                                </td>
                                            </tr>
                                            @endforeach
                                          
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

</div>
</div>

                                                                            

@endsection
<script type="text/javascript">
    function AddUser()
    {

        document.getElementById('user_name').value = "";
        document.getElementById('user_email').value = "";
        document.getElementById('user_id').value = "";
        $('#UserModal').modal('show');
        $('#UserModalLabel').html('Add New User');

        document.getElementById('UserModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('UserModalDialog').style.paddingTop="0px";
        document.getElementById('UserModalData').style.padding="20px 20px 0px 20px";       

        user_type = "0"

        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-user-type-name-list/"+user_type,
        success: function(data) {

            $('#user_type').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }

    function EditUser(id,name,email,user_type)
    {

        document.getElementById('user_name').value = name;
        document.getElementById('user_name').readOnly =true;
        document.getElementById('user_email').value = email;
        document.getElementById('user_email').readOnly = true;
        document.getElementById('user_id').value = id;
        $('#UserModal').modal('show');
        $('#UserModalLabel').html('Edit User');

        document.getElementById('UserModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('UserModalDialog').style.paddingTop="0px";
        document.getElementById('UserModalData').style.padding="20px 20px 0px 20px";       

        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-user-type-name-list/"+user_type,
        success: function(data) {

            $('#user_type').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }

      function DeleteUser(id)
    {

        var r = confirm("Are You Sure? This Can't be Undone.!");
        if (r == false) 
        {
          return;
        }

        $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/delete-user/" + id,
            success: function(data) {
                

                            get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {

                                 document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-danger alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML = get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').style.visibility = "hidden";
                                   

                                }, 5000);

                                }
                                else
                                {
                                    document.getElementById("user"+id).style.display="none";
                                    document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-success alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML =  get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').style.visibility = "hidden";
                                    

                                }, 5000);


                                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
        });


    }


     function BlockUnblockUser(id)
    {


        $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/block-unblock-user/" + id,
            success: function(data) {
                

                get_status = data['status'];
                get_msg    = data['msg'];

                                if (get_status == "0") 
                                {

                                 document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-danger alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML = get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').className = "alert alert-danger alert-rounded fadeOut animated";

                                }, 5000);

                                }
                                else
                                {

                                  if (document.getElementById("status-btn-color"+id).className == "btn btn-pinterest") 
                                  {
                                    document.getElementById("status-btn-color"+id).className = "btn btn-success";
                                    

                                    document.getElementById("status-btn-icon"+id).className = "fa fa-unlock tx-15";
                                    
                                  }
                                  else
                                  {
                                    document.getElementById("status-btn-color"+id).className = "btn btn-pinterest";
                                    

                                    document.getElementById("status-btn-icon"+id).className = "fa fa-lock tx-15";

                                  }

                                    document.getElementById('toast').style.visibility = "visible";
                                    document.getElementById('toast').className = "alert alert-success alert-rounded fadeIn animated";
                                    document.getElementById('toastMsg').innerHTML =  get_msg;


                                     setTimeout(function() {
                                    document.getElementById('toast').className = "alert alert-success alert-rounded fadeOut animated";

                                }, 5000);


                                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Exception:' + errorThrown);
            }
        });


    }

</script>