<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Auth;
use App\Models\User;
use Illuminate\Http\Response;


class AuthApiController extends Controller
{
    //
    public function userlogin(Request $request)
    {
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

    public function login(Request $request)
    {
        try {
            $checkUser = User::where('phone',$request->phone)->first();
            
            if (empty($checkUser) || $checkUser == null) {
                $user = new User;
                $user->phone = $request->phone;
                $user->user_type = 2;
                $user->save();

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Add user  SuccessFully',
                        'status' => 1,
                    ], Response::HTTP_OK);
            }else{

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Already user exists',
                        'status' => 0,
                    ], Response::HTTP_OK);

            }
        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);

        }
    }
}
