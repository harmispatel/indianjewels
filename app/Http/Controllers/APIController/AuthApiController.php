<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Auth;

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
            
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
