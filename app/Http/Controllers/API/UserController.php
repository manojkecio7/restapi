<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
class UserController extends Controller
{
   public $request;
   public function __construct(Request $request){
   			$this->request = $request;
   }
   public function register(){
      // $messages = array(
      //       'email.unique' => 'Email must be unique.',
      //   );
      //     $requestData=$this->request->all();
      //     dd($requestData);
      //   $validator = Validator::make($requestData, array(
      //               'name' => 'required|max:55',
      //               'mobile' => 'required|max:10|min:10|numeric',
      //               'email' => 'email|required|unique:users'
      //                   ), $messages);
         
      //   if ($validator->fails()) { 
      //       return 'working';
      //   } else {
		   	 $validatedData = $this->request->validate([
		   	 	 	'name' => 'required|max:55',
		            'mobile' => 'required|max:10|min:10',
		            'email' => 'email|required'
		            
		        ]);
		   	 // dd($validatedData);

		        $validatedData['password'] = bcrypt($this->request->password);

		        $user = User::create($validatedData);
		      //  dd($user);
		        $accessToken = $user->createToken('authToken')->accessToken;

		        return response([ 'user' => $user, 'access_token' => $accessToken]);
       // }

   }
    public function login(){
      $loginData = $this->request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
   }
   public function profile(){

     echo 'Working Fine'; die;

   }
   public function logout(Request $request)
{        
    if (Auth::check()) {
        $token = Auth::user()->token();
        $token->revoke();
        return $this->sendResponse(null, 'User is logout');
    } 
    else{ 
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'] , Response::HTTP_UNAUTHORIZED);
    } 
}
}
