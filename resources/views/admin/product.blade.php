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
                                <h4 class="card-title">Products
                                    <div class="columns columns-right btn-group float-right">
                                       <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="AddProduct()"><i class="mr-2 mdi mdi-plus-circle"></i> Add Product</button>

                                    </div>
                                </h4>
                                <br>


                                <div class="table-responsive">
                                    <table class="table dataTablesOptions">
                                        <thead class="bg-inverse text-white">
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Name</th>
                                                <th width="15%">Category</th>
                                                <th class="text-center" width="15%">Actual Price</th>
                                                <th class="text-center" width="10%">Sale Price</th>
                                                <th class="text-center" width="10%">Stock</th>
                                                <th class="text-center" width="10%">Status</th>
                                                <th class="text-center" width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="prodTBody">
                                            @foreach($product as $key)
                                            <tr id="prod{{$key['id']}}">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$key['name']}}</td>
                                                <td>{{$key->category_name['name']}}</td>
                                                <td class="text-center">{{$key['actual_price']}}</td>
                                                <td class="text-center">{{$key['sale_price']}}</td>
                                                <td class="text-center">{{$key['stock']}}</td>
                                                <td class="text-center">
                                                    <input type="hidden" id="prod-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                                                    <div  onclick='ChangeProductAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                                                        <div id="prod-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
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
                                                <td class="text-center">
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick='EditProduct("<?php echo $key['id']?>","<?php echo $key['name']?>","<?php echo $key['category_id']?>","<?php echo $key['actual_price']?>","<?php echo $key['sale_price']?>","<?php echo $key['stock']?>","<?php echo $key['description']?>","<?php echo $key['image']?>","<?php echo $key['is_featured']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteProduct("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a>
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
    function AddProduct()
    {
        document.getElementById('prod_name').value = "";
        document.getElementById('prod_actual_price').value = "";
        document.getElementById('prod_sale_price').value = "";
        document.getElementById('prod_stock').value = "";
        document.getElementById('prod_descrip').value = "";
        document.getElementById('prod_id').value = "";
        document.getElementById("product_image").value = "";
        document.getElementById('product_image_output').src = "{{ config('app.img_url')}}choose_img.png";
        $('#ProductModal').modal('show');
        $('#ProductModalLabel').html('Add New Product');

        document.getElementById('ProductModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('ProductModalDialog').style.paddingTop="0px";
        document.getElementById('ProductModalData').style.padding="20px 20px 0px 20px";


        cate_id = "0"

         $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-category-name-list/"+cate_id,
        success: function(data) {

            $('#prod_cate').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }

    function EditProduct(id,name,cate_id,a_price,s_price,stock,description,image,is_feature)
    {
        document.getElementById('prod_name').value = name;
        document.getElementById('prod_actual_price').value = a_price;
        document.getElementById('prod_sale_price').value = s_price;
        document.getElementById('prod_descrip').value = description;
        document.getElementById('prod_stock').value = stock;
        document.getElementById('product_image_output').src = "{{ config('app.img_url')}}"+image;
        document.getElementById('prod_id').value = id;

        if (is_feature == 1) 
        {
            document.getElementById("feature-switch").style.marginLeft = "0px";
            document.getElementById("prod-is-feature-value").value = 1;
        }
        else
        {
            document.getElementById("feature-switch").style.marginLeft = "-56px";
            document.getElementById("prod-is-feature-value").value = 0;
        }

        $('#ProductModal').modal('show');
        $('#ProductModalLabel').html('Edit Product');

        document.getElementById('ProductModal').style.backgroundColor="rgba(0,0,0,0.8)";
        document.getElementById('ProductModalDialog').style.paddingTop="0px";
        document.getElementById('ProductModalData').style.padding="20px 20px 0px 20px";



         $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-category-name-list/"+cate_id,
        success: function(data) {

            $('#prod_cate').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });
    }

    function ChangeProductAvailability(id)
    {   
        var val = document.getElementById("prod-is-show-value"+id).value;

        if (val == 1) 
        {
            document.getElementById("prod-switch"+id).style.marginLeft = "-33px";
            document.getElementById("prod-is-show-value"+id).value = 0;
            var switch_val = 0;
        }
        else
        {
            document.getElementById("prod-switch"+id).style.marginLeft = "0px";
            document.getElementById("prod-is-show-value"+id).value = 1;
            var switch_val = 1;
        }


            $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/change-product-availability/"+id+"/"+switch_val,
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

    function DeleteProduct(id)
    {

        var r = confirm("Are You Sure? This Can't be Undone.!");
        if (r == false) 
        {
          return;
        }

        $.ajax({
            type: "GET",
            cache: false,
            url: "{{ config('app.url')}}admin/delete-product/" + id,
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
                                    document.getElementById("prod"+id).style.display="none";
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