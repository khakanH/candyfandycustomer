<?php
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerToken;
use App\Models\Cart;
use App\Models\CartDetail;

use File;

class AccountController extends Controller
{


    public function __construct(Request $request)
    {

    }


    public function CheckEmailRegistration(Request $request)
    {
        try 
        {
            $input = $request->all();
            $get_email = Customer::where('email',strtolower(trim($input['email'])))->first();

             //check email Already
            if ($get_email != "") 
            {
                return response()->json('Email Address is already taken.');
            }
            else
            {
                return 'true';
            }
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
            
        }
    }


    public function Signup(Request $request)
    {

        try{

            $validator = \Validator::make($request->all(), [
                                                                'name'     => 'required',
                                                                'email'     => 'required',
                                                                'password'  => 'required', 
                                                                'device_type'  => 'required', 
                                                                'device_token'  => 'required', 
                                                            ]);
            

            if ($validator->fails()) 
            {   
                return response()->json(array("msg"=>"Required field is missing.",'status'=>"0"), 200);
            }

            $input = $request->all();
           
           

            $get_email = Customer::where('email',strtolower(trim($input['email'])))->first();

             //check email Already
            if ($get_email != "") 
            {
                 return response()->json(array("status"=>"0","msg"=>"Email address already exist."), 200);
            }
           

            // $code = rand(1111,9999);
            $code = 1234;
            $text_notes = "Thank you for Registering on ......";
            // $this->SendMailVerification("0",$code,$input['email'],$text_notes);

            $data = array(  
                            'name'              => $input['name'],
                            'email'             => strtolower(trim($input['email'])),
                            'password'          => Hash::make($input['password']),
                            'phone'             => isset($input['phone'])?$input['phone']:"",
                            'profile_image'     => "customer/default_user_icon.png",
                            'verification_code' => $code,
                            'account_status'    => 0,
                            'temp_password'     => $input['password'],
                            'device_type'       => $input['device_type'],
                            'device_token'      => $input['device_token'],
                            'created_at'        => date("Y-m-d H:i:s"),
                            'updated_at'        => date("Y-m-d H:i:s"),
                         );


            $id =Customer::insertGetId($data);

            if($id)
            {   
                Cart::insertGetId(array(
                                      "customer_id" => $id,
                                      "total_price" => 0,
                                      "total_item"  => 0,
                                      "created_at"  => date("Y-m-d H:i:s"),
                                      "updated_at"  => date("Y-m-d H:i:s"),
                  ));

                return response()->json(array("status"=>"1","msg"=>"Account Created Successfully"), 200);
               
            }
            else
            {

                return response()->json(array("msg"=>"Something went wrong. Try again later.",'status'=>"0"), 200);
               
            }


        }catch (Exception $e){

            return response()->json($e,500);
        }
    }

   
    public function Login(Request $request)
    {
        try 
        {
            $validator = \Validator::make($request->all(), 
                                        [
                                            'password'    => 'required',
                                            'email'       => 'required',
                                            'device_token'      => 'required',
                                            'device_type'      => 'required',

                                         
                                        ]);

            if ($validator->fails()) 
            {
                return response()->json(array("msg"=>"Required field is missing.",'status'=>"0"), 200);
            }
            
            $input = $request->all();    



           
            $check_account =Customer::where('email',strtolower(trim($input['email'])))
                                                    ->first();
                if ($check_account == "") 
                {
                    return response()->json(array("status"=>"0","msg"=>"Sorry, This email address is not associated with any account"), 200);

                }


                if (!Hash::check($input['password'],$check_account->password)) 
                {
                    return response()->json(array("status"=>"0","msg"=>"Sorry, Invalid Password Entered"), 200);
                }
                




                $generate_token         = Str::random(32);
                $generate_refresh_token = Str::random(32);  
                $token_expiry_time      = time()+2592000;


            if (CustomerToken::where('customer_id',$check_account->id)->count() == 0) 
            {
                CustomerToken::insert(array(
                                                'customer_id'           => $check_account->id,    
                                                'token'                 => $generate_token,
                                                'refresh_token'         => $generate_refresh_token,
                                                'expiry_time'           => $token_expiry_time,
                                                'expiry_time_human_date'=>date("Y-m-d H:i:s",$token_expiry_time),
                                                'created_at'            => date('Y-m-d H:i:s'),
                                                'updated_at'            => date('Y-m-d H:i:s'),
                                            )
                                      );
            }
            else
            {

                CustomerToken::where('customer_id',$check_account->id)->update(array(
                                                'token'         => $generate_token,
                                                'refresh_token' => $generate_refresh_token,
                                                'expiry_time'   => $token_expiry_time,
                                                'expiry_time_human_date'=>date("Y-m-d H:i:s",time()+2592000),
                                                'updated_at'            => date('Y-m-d H:i:s'),
                                            )
                                      );
            }









            Customer::where('email',strtolower(trim($input['email'])))
                    ->update(array('device_token'=>$input['device_token']));





          


            $cart_id = Cart::where('customer_id',$check_account->id)->first();
            if ($cart_id == "") 
            {
                $cart_id = Cart::insertGetId(array(
                                        "customer_id" => $check_account->id,
                                        "total_price" => 0,
                                        "total_item"  => 0,
                                        "created_at"  => date("Y-m-d H:i:s"),
                                        "updated_at"  => date("Y-m-d H:i:s"),
                            ));


            }
            else
            {
                $cart_id = $cart_id->id;
            }
                


            $result = array(    
                                "customer_name"     => $check_account->name,
                                "customer_image"    => $check_account->profile_image,
                                "cart_id"           => $cart_id,
                                "token"             => $generate_token,
                                "refresh_token"     => $generate_refresh_token,
                                "expiry_time"       => $token_expiry_time,
                           );




            return response()->json(array("status"=>"1","msg"=>"Login Successfully","result"=>$result), 200);

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


















    public function LogOut(Request $request)
    {   
        $request->session()->flush(); 
        return redirect()->route('login-form');
    }


}
    