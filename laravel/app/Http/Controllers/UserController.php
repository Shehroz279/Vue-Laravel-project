<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        // dd("aaaa");
        try {
          $user=User::where("userType",'!=','admin')->get();
          // $user = User::all();
          return response()->json(['success'=>true,'user'=> $user],200);
        }
        catch (\Exception $e) {
          return response()->json(['error'=> $e->getMessage()], 400);
        }
      }
      public function view($id){
        try {
          
            $user = User::find($id);
            if($user){
                return response()->json(['success'=>true,'user'=> $user],200);
            }
            else{
                return response()->json(['error'=> 'User Not Found'],400);
            }
        }
        catch (\Exception $e) {
                return response()->json(['error'=> $e->getMessage()],400);
        }
      }
      public function update(UserUpdateRequest $request,$id){
        try {
          if($request->has("password")){
            return response()->json(["error"=> "You didint Allow to set a password"],400);
          }
          else{
            $userAuth = User::find($id);
            if($userAuth){
              // dd($request->all());
              $userAuth->update($request->all());
              return response()->json(['success'=>true,'message'=>"User Update Successfully",'user'=>$userAuth],200);
            }
            else{
              return response()->json(['success'=>true,'message'=>"No user Found"],400);
        
            }
          }
         
        }
        catch (\Exception $e) {
          return response()->json(['error'=> $e->getMessage()], 400);
        }
      }
      public function delete($id){
        try {
            $user = User::find($id);
            if($user){
                $user->delete();
                return response()->json(['success'=>true,'message'=>'User Delete Successfully'],200);
            }
            else{
                return response()->json(['error'=>'User Not Found'],400);
            }
        }
        catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()],400);
        }
      }
}
