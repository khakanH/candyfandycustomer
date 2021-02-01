<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Customer;
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
                                                            ]);
            

            if ($validator->fails()) 
            {   
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $input = $request->all();
           
           

            $get_email = Customer::where('email',strtolower(trim($input['email'])))->first();

             //check email Already
            if ($get_email != "") 
            {
                return redirect()->back()->withInput()->with('failed','Email Address Already Exist');
            }
           

            // $code = rand(1111,9999);
            $code = 1234;
            $text_notes = "Thank you for Registering on ......";
            // $this->SendMailVerification("0",$code,$input['email'],$text_notes);

            $data = array(  
                            'name'              => $input['name'],
                            'email'             => strtolower(trim($input['email'])),
                            'password'          => Hash::make($input['password']),
                            'phone'             => "",
                            'address'           => "",
                            'profile_image'     => "customer/default_user_icon.png",
                            'verification_code' => $code,
                            'account_status'    => 0,
                            'temp_password'     => $input['password'],
                            'created_at'        => date("Y-m-d H:i:s"),
                            'updated_at'        => date("Y-m-d H:i:s"),
                         );


            $id =Customer::insertGetId($data);

            if($id)
            {   
               
                $request->session()->put("success","Account Created Successfully!");
                return redirect()->route('login-form');
            }
            else
            {

                return redirect()->back()->withInput()->with('failed','Something went wrong!');
               
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
                                         
                                        ]);

            if ($validator->fails()) 
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            
            $input = $request->all();    





           
                $check_account =Customer::where('email',strtolower(trim($input['email'])))
                                                    ->first();
                if ($check_account == "") 
                {
                    return redirect()->back()->withInput()->with('failed','Sorry, This Email Address is not associated with any account');

                }


                if (!Hash::check($input['password'],$check_account->password)) 
                {
                    return redirect()->back()->withInput()->with('failed','Sorry, Invalid Password Entered');
                }
                
            $result = array(    
                                "customer_id"           => $check_account->id,
                                "customer_name"         => $check_account->name,
                                "customer_email"        => $check_account->email,
                                "customer_image"        => $check_account->profile_image,
                                "customer_account_status"        => $check_account->account_status,
                           );

            

            if (empty(session('cart_id'))) 
            {
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
            }
            else
            {
                
                $check_cust_cart = Cart::where('customer_id',$check_account->id)->first();

                if ($check_cust_cart == "") 
                {
                    $cart_id = Cart::where('id',session('cart_id'))->first();
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



                    Cart::where('id',$cart_id)->update(array('customer_id'=>$check_account->id));
                    CartDetail::where('cart_id',$cart_id)->update(array('customer_id'=>$check_account->id));

                }
                else
                {
                    $cart_id = $check_cust_cart->id;

                }
              

    
            }





            $request->session()->put("login",$result);
            $request->session()->put("cart_id",$cart_id);
            $request->session()->put("cart_total_item",Cart::where('id',$cart_id)->first()->total_item);

            return redirect()->route('home');

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }




    public function Profile(Request $request)
    {   
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first');
            }          
          }

          

          return view('profile',compact('customer_info'));
        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }







    public function SaveProfile(Request $request)
    {   
      try 
        {
          $customer_id = empty(session("login.customer_id"))?0:session("login.customer_id");

          $customer_info = Customer::where('id',$customer_id)->first();

          if ($customer_info == "") 
          {
            if($request->ajax()) 
            {
              return response()->json(['status'=>"0",'msg' => 'Kindly login first'],401);
            }
            else
            {
              return redirect()->route('login-form')->with('failed','Kindly login first');
            }          
          }



          $validator = \Validator::make($request->all(), [
                                                                'name'     => 'required',
                                                                'address'  => 'required',
                                                                'phone'    => 'required', 
                                                                'email'    => 'required', 
                                                            ]);
            

            if ($validator->fails()) 
            {   
                return redirect()->back()->with('failed','Kindly fill all required fields.');
            }

            $input = $request->all();

            $data =array(
                                                    "name"      => $input['name'],
                                                    "email"     => strtolower(trim($input['email'])),
                                                    "address"   => $input['address'],
                                                    "phone"     => $input['phone'],
                                                );
            if(Customer::where('id',$customer_id)->update($data))
            {
                $request->session()->put("login.customer_name",$input['name']);
                $request->session()->put("login.customer_email",strtolower(trim($input['email'])));
                return redirect()->route('profile')->with('success',"Profile Updated Successfully");
            }
            else
            {
                return redirect()->route('profile')->with('failed',"Failed to Update Profile.");
            }

          

          return view('profile',compact('customer_info'));
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
    