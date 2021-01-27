<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\UserType;
use App\Models\UserRole;
use App\Models\Modules;

use DB;

class UserController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Index(Request $request)
    {	 
        try 
        {
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
           
            $users = Admin::where('id','!=',$user_id)->get();
           
            return view('admin.user',compact('users'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }

    }

    public function AddUpdateUser(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            
            $input = $request->all();


           

            if (empty($input['user_id'])) 
            {   

                if(Admin::where('name',strtolower(trim($input['user_name'])))->count() > 0)
                {
                    return array("status"=>"0","msg"=>"User Name Already Exist.");
                }

                if(Admin::where('email',strtolower(trim($input['user_email'])))->count() > 0)
                {
                    return array("status"=>"0","msg"=>"User Email Already Exist.");
                }
             
                $data = array(
                        "name"                  => strtolower(trim($input['user_name'])),
                        "email"                 => strtolower(trim($input['user_email'])),
                        "password"              => Hash::make('12345'),
                        "user_type"             => $input['user_type'],
                        "is_blocked"            => 0,
                        "created_at"            => date('Y-m-d H:i:s'),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(Admin::insert($data))
                {
                    return array("status"=>"1","msg"=>"User Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed To Add User");

                }
            }
            else
            {
                $data = array(
                        "user_type"             => $input['user_type'],
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(Admin::where('id',$input['user_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"User Updated Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed To Update User");
                }


            }


           
            
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function UserTypeNameList(Request $request,$type)
    {

        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

                 
            $get_user_type_list = UserType::get();
           
            
            if (count($get_user_type_list)==0) 
            {
                ?>
                <option value="" disabled="" selected="">Select User Type</option>
                <?php
            }
            else
            {

                foreach ($get_user_type_list as $key) 
                {
                ?>

                <option   
                        <?php if ((int)$type== $key['id']): ?>
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

    public function UserListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

            $get_user_list = Admin::where('id','!=',$user_id)->get();
           
            
            if (count($get_user_list)==0) 
            {
                ?>
                <tr><td colspan="5" class="text-center tx-18">No User Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_user_list as $key) 
                {
                ?>

                    <tr id="user<?php echo $key['id']?>">
                      <td scope="row"><b><?php echo $count; ?></b></td>
                      <td><?php echo $key['name']?></td>
                      <td><?php echo $key['email']?></td>
                      <td><?php echo $key->user_type_name->name?></td>
                      <td><button data-toggle="tooltip" id="status-btn-color<?php echo $key['id']?>" 
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
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick='EditUser("<?php echo $key['id']?>","<?php echo $key['name']?>","<?php echo $key['email']?>","<?php echo $key['user_type']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteUser("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a></td>
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



    public function DeleteUser(Request $request,$id)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(Admin::where('id',$id)->delete())
            {
                return array("status"=>"1","msg"=>"User Deleted Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Delete User.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }
    

    public function BlockUnblockUser(Request $request,$id)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            
            $status =Admin::where('id',$id)->first()->is_blocked;

            if($status == 0)
            {
                Admin::where('id',$id)->update(array('is_blocked' =>1));
                return array("status"=>"1","msg"=>"User Blocked Successfully.");
            }
            else
            {
                Admin::where('id',$id)->update(array('is_blocked' => 0));
                return array("status"=>"1","msg"=>"User Unblocked Successfully.");
            }

           
        } catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------


    public function UserType(Request $request)
    {    
        try 
        {
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
           
            $user_type = UserType::get();
           
            return view('admin.usertype',compact('user_type'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function AddUpdateUserType(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            
            $input = $request->all();


            if(UserType::where('name',strtolower(trim($input['user_type_name'])))->count() > 0)
            {
                return array("status"=>"0","msg"=>"User Type Name Already Exist.");
            }

            
             

            if (empty($input['user_type_id'])) 
            {   
                $data = array(
                        "name"                  => strtolower(trim($input['user_type_name'])),
                        "created_at"            => date('Y-m-d H:i:s'),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(UserType::insert($data))
                {
                    return array("status"=>"1","msg"=>"User Type Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed");

                }
            }
            else
            {
                $data = array(
                        "name"                  => strtolower(trim($input['user_type_name'])),
                        "updated_at"            => date('Y-m-d H:i:s'),
                        );
                if(UserType::where('id',$input['user_type_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"User Type Updated Successfully.");
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

    public function UserTypeListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

                 $get_user_type_list = UserType::get();
           
            
            if (count($get_user_type_list)==0) 
            {
                ?>
                <tr><td colspan="3" class="text-center tx-18">No User Type Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_user_type_list as $key) 
                {
                ?>

                    <tr id="usertype<?php echo $key['id']?>">
                      <td scope="row"><b><?php echo $count; ?></b></td>
                      <td><?php echo $key['name']?></td>
                      <td><a class="btn btn-primary" href="javascript:void(0)" onclick='EditUserType("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick='DeleteUserType("<?php echo $key['id'] ?>")' href="javascript:void(0)"><i class="fa fa-trash tx-15"></i></a></td>
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


    public function DeleteUserType(Request $request,$id)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(UserType::where('id',$id)->delete())
            {
                return array("status"=>"1","msg"=>"User Type Deleted Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Delete User Type.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------


    public function UserRoles(Request $request)
    {    
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);


            $user_type = UserType::orderBy('id','asc')->get();
            
            if (count($user_type) == 0) 
            {
                return redirect()->route('user-type')->with('failed','Kindly Add User Type First.');
            }


            $all_modules = Modules::where('parent_id',0)->get();
            $all_sub_modules =array();
            foreach ($all_modules as $key) 
            {
                $all_sub_modules[] = Modules::where('parent_id',$key['id'])->get();
            }

            $user_role = UserRole::where('user_type',$user_type[0]['id'])->pluck('module_id')->toArray();

            // print_r($member_role);
            // exit();

            return view('admin.user_role',compact('user_type','all_modules','all_sub_modules','user_role'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }

    }


    public function UserRolesAJAX(Request $request,$id)
    {
        try 
        {   
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);


            $user_role = UserRole::where('user_type',$id)->pluck('module_id')->toArray();

            $all_modules = Modules::where('parent_id',0)->get();

            ?>
                <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $id; ?>">

            <?php

            foreach ($all_modules as $key) 
            {
                $all_sub_modules = Modules::where('parent_id',$key['id'])->get();
                ?>
                 <tr id="user_role<?php echo $key['id'] ?>">
                                                    <td><li><input onclick='ToggleAllSubModule("<?php echo $key['id'] ?>")' id="main_module-cb<?php echo $key['id'] ?>"  type="checkbox" name="main_module-cb[]" value="<?php echo $key['id'] ?>" <?php if (in_array($key['id'], $user_role)): ?>
                                                        checked=""
                                                        <?php else: ?>
                                                    <?php endif ?>>&nbsp;&nbsp;&nbsp;<?php echo $key['name'] ?></li></td>
                                                    <td> 
                                                        <?php foreach($all_sub_modules as $key_): ?>
                                                           <li><input value="<?php echo $key_['id'] ?>" class="sub_module-cb<?php echo $key['id'] ?>" type="checkbox" name="main_module-cb[]" <?php if (in_array($key_['id'], $user_role)): ?>
                                                        checked=""
                                                    <?php endif ?>>&nbsp;&nbsp;&nbsp;<?php echo $key_['name'] ?></li>
                                                       <?php endforeach; ?>
                                                    </td>
                                                </tr>
                <?php


            }





            
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }

    }


    public function SaveRoles(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $input = $request->all();    
           
            UserRole::where('user_type',$input['user_type_id'])->delete();
            
            if (isset($input['main_module-cb'])) 
            {

                foreach ($input['main_module-cb'] as $key) 
                {
                    UserRole::insert(array(
                            'user_type' => $input['user_type_id'],
                            'module_id'   => $key,
                    ));
                }
            }

            
            return array("status"=>"1","msg"=>"User Roles Updated Successfully.");


        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }

    }



    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------







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
    