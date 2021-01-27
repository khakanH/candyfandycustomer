<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Admin;

use File;


class AccountController extends Controller
{

    public function __construct(Request $request)
    {   
    }



    public function Sigin(Request $request)
    {
         try 
        {
            $validator = \Validator::make($request->all(), 
                                        [
                                            'password'          => 'required',
                                            'username_email'    => 'required',
                                         
                                        ]);

            if ($validator->fails()) 
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            
            $input = $request->all();    





           
                $check_account = Admin::where('email',strtolower(trim($input['username_email'])))
                                        ->orwhere('name',strtolower(trim($input['username_email'])))
                                                    ->first();
                if ($check_account == "") 
                {
                    return redirect()->back()->withInput()->with('failed','Sorry, This Username or Email Address is not associated with any account');

                }

           
                if ($check_account->is_blocked == 1) 
                {
                    return redirect()->back()->withInput()->with('failed','Sorry, Your Account Has Been Blocked');

                }


                if (!Hash::check($input['password'],$check_account->password)) 
                {
                    return redirect()->back()->withInput()->with('failed','Sorry, Invalid Password Entered');
                }
                
               
                                   
            $result = array(    
                                "user_id"           => $check_account->id,
                                "user_name"         => $check_account->name,
                                "user_email"        => $check_account->email,
                                "user_type"         => $check_account->user_type,
                           );

            $request->session()->put("admin_login",$result);
            return redirect()->route('dashboard');

        } 
        catch (Exception $e) 
        {
            return response()->json($e,500);
        }
    }


    public function SignOut(Request $request)
    {   
        $request->session()->forget(['admin_login']); 
        return redirect()->route('index');
    }








}
    