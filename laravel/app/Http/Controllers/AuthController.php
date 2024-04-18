<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\SampleMail;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\IsFalse;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
  public function register(UserStoreRequest $request)
  {
    try {
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->userType = $request->userType;
      $user->password = $request->password;
      $otp = random_int(1000, 9999);
      $user->remember_token= $otp;
      $user->save();
      $mail=Mail::to($user->email)->send(new SampleMail($otp));
      $authToken=$user->createToken("token",['authentication'])->plainTextToken;
      if ($mail) {
        return response()->json(['success'=>true,'message' => 'Check Your Email. Emailed Send Successfully',"token"=>$authToken], 200);
      } 
      else {
        return response()->json(['error' => 'Mailed Not Sended'], 400);
      }
    } 
    catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 404);
    }
  }
  public function tokenVerfied(Request $request){
   try{
    $userData=$request->user();
    $request->validate(["otp"=>"required"]);
    $otp=$request->otp;
    $userCheck = User::where("email",$userData['email'])->where('remember_token',$otp);
    if($userCheck->exists()){
        $user = $userCheck->first();
        $userType=$user->userType;
        $token=$user->createToken('authTokenNew',['role-'.$userType])->plainTextToken;
        $user->email_verified_at=date('Y-m-d g:i:s');
        $user->remember_token=NULL;
        $user->save();
        return response()->json(['success'=>true,'message'=> 'You are Log in Successfully','user'=>$user,'token'=> $token],200);     
    }
    else{
        return response()->json(["error"=> "OTP is not matched. "],400);
    }
   }
   catch (\Exception $e) {
    return response()->json(["error"=> $e->getMessage()], 404);
   }
  }
  public function VerificationByEmail(Request $request){
    try{
      
      $request->validate(['email'=>'required']);
      $email=$request->email;
      // dd($request->mail);
      $user = User::where('email', $email)->first();
    
      $otp = random_int(1000, 9999);
      $user->remember_token= $otp;
      $user->save();
      //email send
      $mail=Mail::to($user->email)->send(new SampleMail($otp));

      $authToken=$user->createToken("token",['authentication'])->plainTextToken;
      if($mail){
        return response()->json(['success'=>true,'message' => 'Check Your Email. Emailed Send Successfully',"token"=>$authToken], 200);
     }
      else{
        return response()->json(['error'=> 'Email Not Send There is something error'],400);
      }
    }
    catch (\Exception $e) {
      return response()->json(['error'=> $e->getMessage()], 404);
    }
  }
  public function login(UserLoginRequest $request)
  {
    try {
      $userExists = User::where('email', $request->email)->first();
      if ($userExists) {
        $authenticated = auth()->attempt($request->only(['email', 'password']));
        if ($authenticated) {
          if($userExists->email_verified_at!==null) {
            $user = Auth::user();
            $userType=$user->userType;
            $token=$user->createToken('authTokenNew',['role-'.$userType])->plainTextToken;
            return response()->json(['success'=>true,'message'=>'User Login Successfully','user' => $user,'token' => $token],200);
          }
        else {
          return response()->json(['error'=> 'Verify Your Email First'],400);
        }
        } else {
          return response()->json(['error' => 'Your Email or Password is Invalid'],400);
        }
      } else {
        return response()->json(['error' => 'This Email is not Registered yet'],400);
      }
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
  public function resetPassword(Request $request){
    try {
      $userData=$request->user();
      $request->validate(["otp"=>"required","password"=> "required|string|min:8"]);
      $otp=$request->otp;
      $userCheck = User::where("email",$userData['email'])->where('remember_token',$otp);
      // dd($userData);
      if($userCheck->exists()){
          $user = $userCheck->first();
          $userType=$user->userType;
          $token=$user->createToken('authTokenNew',['role-'.$userType])->plainTextToken;
          $user->email_verified_at=date('Y-m-d g:i:s');
          $user->password=$request->password;
          $user->remember_token=NULL;
          $user->save();
          return response()->json(['success'=>true,'message'=> 'Password is reset and You are Log in','user'=>$user,'token'=> $token],200);     
      }
      else{
          return response()->json(["error"=> "OTP is not matched. "],400);
      }   
    } catch (\Exception $e) {
      return response()->json(['error'=> $e->getMessage()], 400);
    }
  }
  public function logout(Request $request)
  {
    try {
      $user = Auth::user();
      $user->currentAccessToken()->delete();
      return response()->json(['success'=>true,'message' => 'User logged out'],200);
    }
    catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
  public function logoutAllDevices(Request $request){
    try {
      $user = Auth::user();
      $user->tokens()->delete();
      return response()->json(['success'=>true,'message'=> 'Logout From All Devices'],200);
    }
    catch (\Exception $e) {
      return response()->json(['error'=> $e->getMessage()], 400);
    }
  }
}
