<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;

use App\Models\PaymentMethod;
use App\Models\GeneralSetting;
use App\Models\CancelReason;


use DB;

class GeneralSettingController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Index(Request $request)
    {	
        try
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $setting = GeneralSetting::first();

            return view('admin.general_setting',compact('setting'));
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }

    public function SaveGeneralSetting(Request $request)
    {   
        try
        {

            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $input = $request->all();

            $id = GeneralSetting::first()->id;

              
                $data = array(
                            'phone'         => $input['phone'],
                            'email'         => $input['email'],
                            'website'       => $input['website'],
                            'location'      => $input['location'],
                            'shipping_fee'  => $input['shipping'],
                            'discount'      => $input['discount'],
                            );
                if(GeneralSetting::where('id',$id)->update($data))
                {
                    return redirect()->route('general-setting')->with('success','General Setting Updated Successfully');
                }
                else
                {
                    return redirect()->back()->with('failed','Failed to Update General Setting');
                   
                }
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
        

    }

    public function PaymentMethod(Request $request)
    {   
        try
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $payment = PaymentMethod::get();

            return view('admin.payment_method',compact('payment'));
        
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }



    public function AddUpdatePaymentMethod(Request $request)
    {  
        try
        { 
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $input = $request->all();


            if (empty($input['payment_id'])) 
            {   
                $data = array(
                            'name'          => $input['payment_name'],
                            'is_show'       => 1,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s'),
                            );
                if(PaymentMethod::insert($data))
                {
                    return array("status"=>"1","msg"=>"Payment Method Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed to Add Payment Method.");
                }


            }
            else
            {
                $data = array(
                            'name'          => $input['payment_name'],
                            );

                if(PaymentMethod::where('id',$input['payment_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"Payment Method Updated Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed to Update Payment Method.");
                }

            }
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function PaymentMethodListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

            $get_payment_list = PaymentMethod::get();
           
            
            if (count($get_payment_list)==0) 
            {
                ?>
                <tr><td colspan="4" class="text-center tx-18">No Payment Method Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_payment_list as $key) 
                {
                ?>

                    <tr id="payment<?php echo $key['id']?>">
                      <td scope="row"><b><?php echo $count; ?></b></td>
                      <td><?php echo $key['name']?></td>
                      <td><input type="hidden" id="payment-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                                                    <div  onclick='ChangePaymentAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                                                        <div id="payment-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
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
                      <td><a class="btn btn-primary" href="javascript:void(0)" onclick='EditPayment("<?php echo $key['id']?>","<?php echo $key['name']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;</td>
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



    public function ChangePaymentAvailability(Request $request,$id,$val)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(PaymentMethod::where('id',$id)->update(array('is_show'=>$val)))
            {
                return array("status"=>"1","msg"=>"Payment Method Status Updated Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Update Payment Method Status.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }



    public function CancelReason(Request $request)
    {   
        try
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $reason = CancelReason::get();

            return view('admin.cancel_reason',compact('reason'));
        
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }



    public function AddUpdateCancelReason(Request $request)
    {  
        try
        { 
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            $input = $request->all();


            if (empty($input['reason_id'])) 
            {   
                $data = array(
                            'name'          => $input['reason_name'],
                            'type'          => $input['reason_type'],
                            'is_show'       => 1,
                            'created_at'    => date('Y-m-d H:i:s'),
                            'updated_at'    => date('Y-m-d H:i:s'),
                            );
                if(CancelReason::insert($data))
                {
                    return array("status"=>"1","msg"=>"Cancel Reason Added Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed to Add Cancel Reason.");
                }


            }
            else
            {
                $data = array(
                            'name'          => $input['reason_name'],
                            'type'          => $input['reason_type'],
                            );

                if(CancelReason::where('id',$input['reason_id'])->update($data))
                {
                    return array("status"=>"1","msg"=>"Cancel Reason Updated Successfully.");
                }
                else
                {
                    return array("status"=>"0","msg"=>"Failed to Update Cancel Reason.");
                }

            }
        }
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function CancelReasonListAJAX(Request $request)
    {
        try 
        {   
            $user_id = session("admin_login")["user_id"];

            $user_info = $this->checkUserAvailbility($user_id,$request);
            

            $get_reason_list = CancelReason::get();
           
            
            if (count($get_reason_list)==0) 
            {
                ?>
                <tr><td colspan="4" class="text-center tx-18">No Cancel Reason Found</td></tr>
                <?php
            }
            else
            {

                $count= 1;
                foreach ($get_reason_list as $key) 
                {
                ?>

                    <tr id="reason<?php echo $key['id']?>">
                      <td scope="row"><b><?php echo $count; ?></b></td>
                      <td><?php echo $key['name']?></td>
                      <td><?php echo ($key['type'] == 1)?"Customer":"Shop Keeper"?></td>
                      <td><input type="hidden" id="reason-is-show-value<?php echo $key['id'] ?>" value="<?php echo $key['is_show'] ?>">
                                                    <div  onclick='ChangeReasonAvailability("<?php echo $key['id'] ?>")' class="bootstrap-switch-mini bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 68px;">
                                                        <div id="reason-switch<?php echo $key['id'] ?>" class="bootstrap-switch-container" style="width: 99px;
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
                      <td><a class="btn btn-primary" href="javascript:void(0)" onclick='EditReason("<?php echo $key['id']?>","<?php echo $key['name']?>","<?php echo $key['type']?>")'><i class="fa fa-edit tx-15"></i></a>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="javascript:void(0)" onclick='DeleteReason("<?php echo $key['id']?>")'><i class="fa fa-trash tx-15"></i></a></td>
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



    public function ChangeCancelReasonAvailability(Request $request,$id,$val)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(CancelReason::where('id',$id)->update(array('is_show'=>$val)))
            {
                return array("status"=>"1","msg"=>"Cancel Reason Status Updated Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Update Cancel Reason Status.");
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function DeleteCancelReason(Request $request,$id)
    {
        try 
        {
            $user_id = session("admin_login.user_id");

            $user_info = $this->checkUserAvailbility($user_id,$request);

            if(CancelReason::where('id',$id)->delete())
            {
                return array("status"=>"1","msg"=>"Cancel Reason Deleted Successfully.");
            }
            else
            {
                return array("status"=>"0","msg"=>"Failed to Delete Cancel Reason.");
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
    