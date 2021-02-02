<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;

use App\Models\Category;
use App\Models\Product;


use DB;
use File;

class InventoryController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function CategoryList(Request $request)
    {	
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $category = Category::get();

            return view('admin.category',compact('category'));
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }

    }


    public function AddUpdateCategory(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            
            $input = $request->all();


            if(Category::where('name',strtolower(trim($input['cate_name'])))->count() > 0)
            {
                return array("status"=>"0","msg"=>"Category Name Already Exist.");
            }

            
             

            if (empty($input['cate_id'])) 
            {   
                $data = array(
                        "name"                  => strtolower(trim($input['cate_name'])),
                        "is_show"               => 1,
                        "created_at"            => date('Y-m-d H:i:s'),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(Category::insert($data))
                {
                    return array("status"=>"1","msg"=>"Category Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed");

                }
            }
            else
            {
                $data = array(
                        "name"                  => strtolower(trim($input['cate_name'])),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(Category::where('id',$input['cate_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"Category Updated Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed");
                }


            }


           
            
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function CategoryListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

                 $get_cate_list = Category::get();
           
            
            if (count($get_cate_list)==0) 
            {
                ?>
                <tr><td colspan="4" class="text-center tx-18">No Category Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_cate_list as $key) 
                {
                ?>

                    <tr id="cate<?php echo $key['id']?>">
                      <td scope="row"><b><?php echo $count; ?></b></td>
                      <td><?php echo $key['name']?></td>
                      <td><input type="hidden" id="cate-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
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
                                                    </div></td>
                      <td><a class="btn btn-primary" href="javascript:void(0)" onclick='EditCategory("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteCategory("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a></td>
                    </tr>

                <?php
                $count++;
                } 
            }

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }



    public function ChangeCategoryAvailability(Request $request,$id,$val)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(Category::where('id',$id)->update(array('is_show'=>$val)))
            {
                return array("status"=>"1","msg"=>"Category Status Updated Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Update Category Status.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }
    
    public function DeleteCategory(Request $request,$id)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(Category::where('id',$id)->delete())
            {
                return array("status"=>"1","msg"=>"Category Deleted Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Delete Category.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }




    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------






    public function ProductList(Request $request)
    {   
        try
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $product = Product::get();

            return view('admin.product',compact('product'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function AddUpdateProduct(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            
            $input = $request->all();


            
           

            
             

            if (empty($input['prod_id'])) 
            {   
                if(Product::where('name',strtolower(trim($input['prod_name'])))->where('category_id',$input['prod_cate'])->count() > 0)
                {
                    return array("status"=>"0","msg"=>"Product Name Already Exist.");
                }


                $image= $request->file('product_image');
                if (empty($image)) 
                {

                    $path = "default_product.png";
                
                }
                else
                {   

                    $input['imagename'] =  uniqid().'.webp';
                   
                    $destinationPath = public_path('/assets/images/product');

                    if($image->move($destinationPath, $input['imagename']))
                    {
                            $path =  'product/'.$input['imagename'];
                    }
                    else
                    {       
                        return array("status"=>"0","msg"=>"Something Went Wrong for Image Uploading.");
                    }

                }


                $data = array(
                        "name"                  => strtolower(trim($input['prod_name'])),
                        "category_id"           => $input['prod_cate'],
                        "actual_price"          => $input['prod_actual_price'],
                        "sale_price"            => $input['prod_sale_price'],
                        "image"                 => $path,
                        "description"            => $input['prod_descrip'],
                        "stock"                 => $input['prod_stock'],
                        "is_show"               => 1,
                        "is_featured"           => $input['is_featured'],
                        "created_at"            => date('Y-m-d H:i:s'),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(Product::insert($data))
                {
                    return array("status"=>"1","msg"=>"Product Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed");

                }
            }
            else
            {   

               

                if(Product::where('name',strtolower(trim($input['prod_name'])))->where('category_id',$input['prod_cate'])->where('id','!=',$input['prod_id'])->count() > 0)
                {
                    return array("status"=>"0","msg"=>"Product Name Already Exist.");
                }

                
                $get_product = Product::where('id',$input['prod_id'])->first();


               
                $image= $request->file('product_image');
                if (empty($image)) 
                {

                    $path = $get_product->image;
                
                }
                else
                {   

                    $input['imagename'] =  uniqid().'.webp';
                   
                    $destinationPath = public_path('/assets/images/product');

                    if($image->move($destinationPath, $input['imagename']))
                    {
                            $path =  'product/'.$input['imagename'];
                    }
                    else
                    {       
                        return array("status"=>"0","msg"=>"Something Went Wrong for Image Uploading.");
                    }
                    
                    if ($get_product->image != "default_product.png") 
                    {
                        $image_path = public_path('assets/images/'.$get_product->image);  // Value is not URL but directory file path
                        if(File::exists($image_path)) {
                            File::delete($image_path);
                        }
                    }


                }






                


               $data = array(
                        "name"                  => strtolower(trim($input['prod_name'])),
                        "category_id"           => $input['prod_cate'],
                        "actual_price"          => $input['prod_actual_price'],
                        "sale_price"            => $input['prod_sale_price'],
                        "image"                 => $path,
                        "description"           => $input['prod_descrip'],
                        "stock"                 => $input['prod_stock'],
                        "is_featured"           => $input['is_featured'],
                        );
                if(Product::where('id',$input['prod_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"Product Updated Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed");
                }


            }


           
            
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function ProductListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

            $get_prod_list = Product::get();
           
            
            if (count($get_prod_list)==0) 
            {
                ?>
                <tr><td colspan="8" class="text-center tx-18">No Product Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_prod_list as $key) 
                {
                ?>

                    <tr id="prod<?php echo $key['id']?>">
                        <td scope="row"><b><?php echo $count; ?></b></td>
                        <td><?php echo $key['name']?></td>
                        <td><?php echo $key->category_name['name'] ?></td>
                        <td class="text-center"><?php echo $key['actual_price'] ?></td>
                        <td class="text-center"><?php echo $key['sale_price'] ?></td>
                        <td class="text-center"><?php echo $key['stock'] ?></td>
                        <td class="text-center">
                            <input type="hidden" id="prod-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                            <div  onclick='ChangeProductAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                            <div id="prod-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
                            <?php if ($key['is_show'] == 1): ?>
                                margin-left: 0px;
                            <?php else: ?>
                                margin-left: -33px;
                            <?php endif; ?>">
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

                <?php
                $count++;
                } 
            }

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }



    public function CategoryNameList(Request $request,$cate_id)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

                 
                    $get_cate_list = Category::get();
           
            
            if (count($get_cate_list)==0) 
            {
                ?>
                <option value="" disabled="" selected="">Select Category</option>
                <?php
            }
            else
            {

                foreach ($get_cate_list as $key) 
                {
                ?>

                <option   
                        <?php if ((int)$cate_id== $key['id']): ?>
                            selected
                        <?php endif ?>
                 value="<?php echo $key['id'] ?>"><?php echo $key['name'] ?></option>
                    

                <?php
                } 
            }

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }



    public function ChangeProductAvailability(Request $request,$id,$val)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(Product::where('id',$id)->update(array('is_show'=>$val)))
            {
                return array("status"=>"1","msg"=>"Product Status Updated Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Update Product Status.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function DeleteProduct(Request $request,$id)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(Product::where('id',$id)->delete())
            {
                return array("status"=>"1","msg"=>"Product Deleted Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Delete Product.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }





















    public function checkUserAvailbility($id,$request)
    {   

       
        $user = Admin::where('id',$id)->where('is_blocked',0)->first();


        if ($user == "") 
        {   

            if($request->ajax()) 
            {
                return response()->json(['status'=>"0",'msg' => 'Session expired'],401);
            }
            else
            {
                $request->session()->put("failed","Something went wrong.");
                header('Location:'.url('signout'));
            }
            
            exit();
        }
        else
        {   
            return $user;
        }
    }
    


}
    