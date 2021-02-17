
<div id="LoadingModal" class="modal" data-backdrop="false" data-keyboard="true" style="height: 1%; background: rgba(0,0,0,0.6);">
          <center><img style="width: 200%;" src="<?php echo config('app.img_url') ?>loading_bar.gif" width="100%" height="20"></center>
</div>



<div class="" id="toast" style="visibility: hidden; position: fixed; bottom: 5px; left: 30px; z-index: 999999999; font-size: 15px;">
                                        <p id="toastMsg" style="float: left;"></p> 
                                            <button type="button" class="close" onclick="hideToast('toast')" aria-label="Close" style="float: right;"> &nbsp;&nbsp;&nbsp;<span aria-hidden="true">×</span> </button>
                                        </div>






<!-- Category Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="CategoryModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" id="CategoryModalDialog">
        <div class="modal-content" id="CategoryModalContent">
           
            <form name="categoryForm" enctype="multipart/form-data" id="cateForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="CategoryModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="CategoryModalData">

                      <input type="hidden" id="cate_id" name="cate_id">


                        
                        <div class="form-group">
                          <input type="text" id="cate_name" name="cate_name" class="form-control" placeholder="Enter Category Name">
                        </div>
                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="CategoryModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<!-- Product Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="ProductModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-lg" id="ProductModalDialog">
        <div class="modal-content" id="ProductModalContent">
           
            <form name="productForm" enctype="multipart/form-data" id="prodForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="ProductModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="ProductModalData">

                        <input type="hidden" id="prod_id" name="prod_id">


                        
                        <div class="row">
                          <!-- <div class="col-lg-6">  -->
                            <!-- <label>Product Code: <i style="font-size: 12px">(Barcode)</i></label>
                            <input type="text" id="prod_code" name="prod_code" class="form-control" placeholder="Enter Product Code"></div> -->
                            <!-- <div class="col-lg-3"> 
                            <label>PCT Code: <i style="font-size: 12px">(optional)</i></label>
                            <input type="text" id="pct_code" name="pct_code" class="form-control" placeholder="Enter PCT Code"  data-toggle="tooltip" title="Only Required For FBR Integration"></div> -->
                          <div class="col-lg-6"> 
                            <label>Product Name:</label>
                            <input type="text" id="prod_name" name="prod_name" class="form-control" placeholder="Enter Product Name"></div>
                          <div class="col-lg-6"> 
                            <label>Product Category:</label>
                            <select class="form-control" name="prod_cate" id="prod_cate">
                              <option value="" disabled="" selected="">Selecet Category</option>
                            </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          
                          <div class="col-lg-6"> 
                            <label>Actual Price: </label>
                            <input type="number" id="prod_actual_price" name="prod_actual_price" class="form-control" placeholder="Enter Actual Price"></div>
                              <div class="col-lg-6"> 
                            <label>Sale Price:</label>
                            <input type="number" id="prod_sale_price" name="prod_sale_price" class="form-control" placeholder="Enter Sale Price" ></div>
                        </div>
                        <br>
                        
                        <div class="row">
                            <div class="col-lg-6">
                            <label>Stock: </label>
                            <input type="number" id="prod_stock" name="prod_stock" class="form-control" placeholder="Enter Product Stock">
                            </div>
                            <div class="col-lg-6">
                            <label>Is Featured: </label>
                              <br>
                               <input type="hidden" name="is_featured" id="prod-is-feature-value" value="0">
                              <div onclick="ChangeItemFeature()" class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 110px; height: 34px;">
                                                        <div id="feature-switch" class="bootstrap-switch-container" style="width: 164px;
                                                          margin-left: -56px;
                                                         ">
                                                            <span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 58px; height: 33px;">ON</span>
                                                            <span class="bootstrap-switch-label" style="width: 58px; height: 33px;">&nbsp;</span>
                                                            <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 58px; height: 33px;">OFF</span>
                                                            <input type="checkbox" checked="" data-size="mini">
                                                        </div>
                                                    </div>


                            </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-6"> 
                            <label>Product Image:</label><br>
                            <img id="product_image_output" src="{{ config('app.img_url')}}choose_img.png" width="130" height="130" style="border-radius: 2%; border: solid gray 1px; object-position: top; object-fit: cover;">&nbsp;&nbsp;<input type="file"  name="product_image" id="product_image" onchange="product_loadFile(event)"  accept="image/*" ></div>
                          <div class="col-lg-6"> 
                            <label>Product Description:</label>
                            <textarea class="form-control" name="prod_descrip" id="prod_descrip" rows="5" placeholder="Enter Product Description"></textarea></div>
                        </div>


                      </div>
              

                      </div>
                  <div class="modal-footer" id="ProductModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->












<!-- User Type Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="UserTypeModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" id="UserTypeModalDialog">
        <div class="modal-content" id="UserTypeModalContent">
           
            <form name="userTypeForm" enctype="multipart/form-data" id="userTypeForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="UserTypeModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="UserTypeModalData">

                      <input type="hidden" id="user_type_id" name="user_type_id">


                        
                        <div class="form-group">
                          <input type="text" id="user_type_name" name="user_type_name" class="form-control" placeholder="Enter User Type Name">
                        </div>
                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="UserTypeModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->







<!-- User Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="UserModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" id="UserModalDialog">
        <div class="modal-content" id="UserModalContent">
           
            <form name="userForm" enctype="multipart/form-data" id="userForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="UserModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="UserModalData">


                      <input type="hidden" id="user_id" name="user_id">

                        
                        <div class="form-group">
                          <label>Name:</label>
                          <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Enter User Name">
                        </div>
                        <div class="form-group">
                          <label>Email:</label>
                          <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Enter User Email">
                        </div>

                        <div class="form-group">
                          <label>User Type:</label>
                          <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                          </select>
                        </div>



                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="UserModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<!-- Payment Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="PaymentModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" id="PaymentModalDialog">
        <div class="modal-content" id="PaymentModalContent">
           
            <form name="paymentForm" enctype="multipart/form-data" id="paymentForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="PaymentModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="PaymentModalData">

                      <input type="hidden" id="payment_id" name="payment_id">


                        
                        <div class="form-group">
                          <input type="text" id="payment_name" name="payment_name" class="form-control" placeholder="Enter Payment Name">
                        </div>
                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="PaymentModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->


<!-- Cancel Reason Modal                                         -->
<!-- ----------------------------------------------------------------------------------------------------- -->

<div id="CancelReasonModal" class="modal fade show " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog" id="CancelReasonModalDialog">
        <div class="modal-content" id="CancelReasonModalContent">
           
            <form name="reasonForm" enctype="multipart/form-data" id="reasonForm">
              @csrf
               <span class='arrow'>
              <label class='error'></label>
              </span>
                  <div class="modal-header">
                      <h4 class="modal-title" id="CancelReasonModalLabel"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="CancelReasonModalData">

                      <input type="hidden" id="reason_id" name="reason_id">


                        
                        <div class="form-group">
                          <input type="text" id="reason_name" name="reason_name" class="form-control" placeholder="Enter Cancel Reason Name">
                          <br>
                          <select class="form-control" name="reason_type" id="reason_type">
                            <option value="">Select Cancel Reason Type</option>
                            <option value="1">Customer</option>
                            <option value="2">Shop Keeper</option>
                          </select>
                        </div>
                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="CancelReasonModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-info ">Save</button>

                  </div>
            </form>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------------------------------------- -->






<script type="text/javascript">
    
    $(function() {
        $("form[name='categoryForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      cate_name: {
        required: true,
      },
    },
    messages: {
      cate_name: {
        required: "Please Provide a Category Name",
      },
     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('cateForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-category",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#CategoryModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-category-list-AJAX",
        success: function(data) {

            $('#cateTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });

    //-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------






     $(function() {
        $("form[name='productForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      prod_name: {
        required: true,
      },
      prod_cate: {
        required: true,
      },
     
      prod_actual_price: {
        required: true,
      },
      prod_sale_price: {
        required: true,
      },
     prod_stock: {
        required: true,
      },

    },
    messages: {
      prod_name: {
        required: "Please Provide a Product Name",
      },
      prod_cate: {
        required: "Please Select a Product Category",
      },
      
      prod_actual_price: {
        required: "Please Provide a Product Actual Price",
      },
      prod_sale_price: {
        required: "Please Provide a Product Sale Price",
      },
       prod_stock: {
        required: "Please Provide a Product Stock",
      },
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('prodForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-product",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#ProductModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-product-list-AJAX",
        success: function(data) {

            $('#prodTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });

// ----------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------

 $(function() {
        $("form[name='userTypeForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      user_type_name: {
        required: true,
      },
    },
    messages: {
      user_type_name: {
        required: "Please Provide a User Type Name",
      },
     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('userTypeForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-user-type",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#UserTypeModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-user-type-list-AJAX",
        success: function(data) {

            $('#usertypeTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });

    //-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------




 $(function() {
        $("form[name='userForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      user_name: {
        required: true,
      },
      user_email: {
        required: true,
      },
      user_type: {
        required: true,
      },
    },
    messages: {
      user_name: {
        required: "Please Provide a User Name",
      },
       user_email: {
        required: "Please Provide a User Email",
      },

        user_type: {
        required: "Please Select a User Type",
      },     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('userForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-user",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#UserModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-user-list-AJAX",
        success: function(data) {

            $('#userTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });



// ----------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------
$(function() {
        $("form[name='paymentForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      payment_name: {
        required: true,
      },
    },
    messages: {
      payment_name: {
        required: "Please Provide a Payment Name",
      },
     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('paymentForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-payment-method",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#PaymentModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-payment-method-list-AJAX",
        success: function(data) {

            $('#paymentTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });



//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

$(function() {
        $("form[name='reasonForm']").validate({
             errorPlacement: function(label, element) {
        label.addClass('arrow');
        label.css({"color": "red", "font-size": "12px" ,"width":"100%"});
        label.insertAfter(element);
    },
    wrapper: 'span',

    rules: {
      reason_name: {
        required: true,
      },
      reason_type: {
        required: true,
      },
    },
    messages: {
      reason_name: {
        required: "Please Provide a Cancel Reason Name",
      },
      reason_type: {
        required: "Please Select a Cancel Reason Type",
      },
     
    },
    submitHandler: function(form) {

        let myForm = document.getElementById('reasonForm');
        let formData = new FormData(myForm);

         $.ajax({
        type: "POST",
        cache: false,
        url: "{{ config('app.url')}}admin/add-update-cancel-reason",
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
                            $('#CancelReasonModal').modal('hide');
                        },
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
                                document.getElementById('toastMsg').innerHTML = get_msg;


                                 setTimeout(function() {
                             document.getElementById('toast').style.visibility = "hidden";

                            }, 5000);


                            }


        $.ajax({
        type: "GET",
        cache: false,
        url: "{{ config('app.url')}}admin/get-cancel-reason-list-AJAX",
        success: function(data) {

            $('#reasonTBody').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Exception:' + errorThrown);
        }
    });

    }
  });

    }
  });
  });



//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

var product_loadFile = function(event) {
    var product_image_output = document.getElementById('product_image_output');
    product_image_output.src = URL.createObjectURL(event.target.files[0]);
    product_image_output.onload = function() {
      URL.revokeObjectURL(product_image_output.src) // free memory
    }
  };


  function ChangeItemFeature()
  {
    var val = document.getElementById("prod-is-feature-value").value;

        if (val == 1) 
        {
            document.getElementById("feature-switch").style.marginLeft = "-56px";
            document.getElementById("prod-is-feature-value").value = 0;
        }
        else
        {
            document.getElementById("feature-switch").style.marginLeft = "0px";
            document.getElementById("prod-is-feature-value").value = 1;
        }
  }
</script>