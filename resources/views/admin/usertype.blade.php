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
                                <h4 class="card-title">Users Type
                                    <div class="columns columns-right btn-group float-right">
                                       
                                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="AddUserType()"><i class="mr-2 mdi mdi-plus-circle"></i> Add User Type </button>

                                    </div>
                                </h4>
                                <br>


                                <div class="table-responsive">
                                    <table class="table dataTablesOptions text-center">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Name</th>
                                                <th width="30%">Action</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody id="usertypeTBody">
                                           @foreach($user_type as $key)
                                            <tr id="usertype{{$key['id']}}">
                                                <td  class="text-center">{{$loop->iteration}}</td>
                                                <td>{{$key['name']}}</td>
                                                
                                                <td>
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick='EditUserType("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteUserType("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a>
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
    function AddUserType()
    {

        document.getElementById('user_type_name').value = "";
        document.getElementById('user_type_id').value = "";
        $('#UserTypeModal').modal('show');
        $('#UserTypeModalLabel').html('Add New User Type');

        document.getElementById('UserTypeModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('UserTypeModalDialog').style.paddingTop="0px";
        document.getElementById('UserTypeModalData').style.padding="20px 20px 0px 20px";       

    }

    function EditUserType(id,name)
    {
        document.getElementById('user_type_name').value = name;
        document.getElementById('user_type_id').value = id;
        $('#UserTypeModal').modal('show');
        $('#UserTypeModalLabel').html('Edit User Type');

        document.getElementById('UserTypeModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('UserTypeModalDialog').style.paddingTop="0px";
        document.getElementById('UserTypeModalData').style.padding="20px 20px 0px 20px";
    }

    function DeleteUserType(id)
    {

        var r = confirm("Are You Sure? This Can't be Undone.!");
        if (r == false) 
        {
          return;
        }

        $.ajax({
            type: "GET",
            url: "{{ config('app.url')}}admin/delete-user-type/" + id,
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
                                    document.getElementById("usertype"+id).style.display="none";
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
</script>