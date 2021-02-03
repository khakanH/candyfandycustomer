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
                                <h4 class="card-title">Categories
                                    <div class="columns columns-right btn-group float-right">
                                       <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="AddCategory()"><i class="mr-2 mdi mdi-plus-circle"></i> Add Category</button>

                                    </div>
                                </h4>
                                <br>


                                <div class="table-responsive">
                                    <table class="table dataTablesOptions" id="example" style="width:100%">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                
                                                <th  class="text-center" width="5%">#</th>
                                                <th width="25%">Name</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cateTBody">
                                            @foreach($category as $key)
                                            <tr id="cate{{$key['id']}}">
                                                <td  class="text-center">{{$loop->iteration}}</td>
                                                <td>{{$key['name']}}</td>
                                                <td>
                                                    <input type="hidden" id="cate-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                                                    <div  onclick='ChangeCategoryAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                                                        <div id="cate-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
                                                         <?php if ($key['is_show'] == 1): ?>
                                                             margin-left: 0px;
                                                         <?php else: ?>
                                                             margin-left: -33px;
                                                         <?php endif; ?>

                                                         ">
                                                            <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 33px;">ON</span>
                                                            <span class="bootstrap-switch-label" style="width: 33px;">&nbsp;</span>
                                                            <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 33px;">OFF</span>
                                                            <input type="checkbox" checked="" data-size="mini">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick='EditCategory("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteCategory("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a>
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

    
    function AddCategory()
    {
        document.getElementById('cate_name').value = "";
        document.getElementById('cate_id').value = "";
        $('#CategoryModal').modal('show');
        $('#CategoryModalLabel').html('Add New Category');

        document.getElementById('CategoryModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('CategoryModalDialog').style.paddingTop="0px";
        document.getElementById('CategoryModalData').style.padding="20px 20px 0px 20px";
    }

    function EditCategory(id,name)
    {
        document.getElementById('cate_name').value = name;
        document.getElementById('cate_id').value = id;
        $('#CategoryModal').modal('show');
        $('#CategoryModalLabel').html('Edit Category');

        document.getElementById('CategoryModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('CategoryModalDialog').style.paddingTop="0px";
        document.getElementById('CategoryModalData').style.padding="20px 20px 0px 20px";
    }

    function ChangeCategoryAvailability(id)
    {   
        var val = document.getElementById("cate-is-show-value"+id).value;

        if (val == 1) 
        {
            document.getElementById("cate-switch"+id).style.marginLeft = "-33px";
            document.getElementById("cate-is-show-value"+id).value = 0;
            var switch_val = 0;
        }
        else
        {
            document.getElementById("cate-switch"+id).style.marginLeft = "0px";
            document.getElementById("cate-is-show-value"+id).value = 1;
            var switch_val = 1;
        }


            $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/change-category-availability/"+id+"/"+switch_val,
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

    function DeleteCategory(id)
    {

        var r = confirm("Are You Sure? This Can't be Undone.!");
        if (r == false) 
        {
          return;
        }

        $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/delete-category/" + id,
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
                                    document.getElementById("cate"+id).style.display="none";
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