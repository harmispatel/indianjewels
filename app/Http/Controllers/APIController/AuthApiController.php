<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    //
    public function userlogin(Request $request)
    {

        try {
            $find_user = User::where('email',$request->email)->first();
            if(isset($find_user)){
                if($find_user->status == 1){
                    if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){

                        $user = new CustomerResource(Auth::guard('web')->user());

                        $token =  $user->createToken('MyApp')-> accessToken;

                        $data = ['user' => $user, 'token' => $token];
                        return $this->sendResponse(true, 'User Logged In Successfully...', $data);
                    }
                    else{

                        return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
                    }
                }
                else{
                    return $this->sendApiResponse(false, 0,'You Account has been Blocked!', (object)[]);
                }
            }else{
                return $this->sendApiResponse(false, 0,'Please Enter a Valid Email', (object)[]);
            }

        } catch (\Throwable $th) {

            return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
        }
    }

    public function login(Request $request)
    {
        try {
            $customer = User::where('phone',$request->phone)->first();

            if (!isset($customer->id) && empty($customer->id)) {
                $new_customer = new User;
                $new_customer->phone = $request->phone;
                $new_customer->user_type = 2;
                $new_customer->status = 1;
                $new_customer->verification = 1;
                $new_customer->save();

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Customer has been Registerd SuccessFully.',
                        'status' => 1,
                        'user_type' => $new_customer->user_type,
                        'user_id' => $new_customer->id,
                        'verification' => $new_customer->verification,
                    ], Response::HTTP_OK);
            }else{
                if($customer->status == 1){
                    return response()->json(
                    [
                        'success' => true,
                        'message' => 'Customer has already Registerd.',
                        'status' => 1,
                        'user_type' => $customer->user_type,
                        'user_id' => $customer->id,
                        'verification' => $customer->verification,
                    ], Response::HTTP_OK);
                }else{
                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Your Account has been Blocked By ADMIN!',
                            'status' => 0,
                            'user_type' => $customer->user_type,
                            'user_id' => $customer->id,
                            'verification' => $customer->verification,
                        ], Response::HTTP_OK);
                }
            }
        } catch (\Throwable $th) {

            return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
        }
    }
}
