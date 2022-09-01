<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $validation=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string',
            'phone'=>'required',
            'address'=>'required|string',
            'password'=>'required|string|confirmed',
            'password_confirmation'=>'required'
        ]);
        // $validation=$request->validate([
        //     'name'=>'required|string',
        //     'email'=>'required|string|unique:users,email',
        //     'phone'=>'required',
        //     'address'=>'required|string',
        //     'password'=>'require|string|confirmed'
        // ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'password'=>Hash::make($request->password)
        ]);
        $user=User::where('email',$request->email)->first();
        $token=$user->createToken('myToken')->plainTextToken;
        return Response::json([
            'message'=>$user,
            'token'=>$token,
        ]);
    }
    public function login(Request $request){
        $validation=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
        ]);
        $user=User::where('email',$request->email)->first();

        if(empty($user)|| !Hash::check($request->password,$user->password )){
            return Response::json([
                'message'=>"Credential Do not Match!",
            ],200);
        }
        $token=$user->createToken('myToken')->plainTextToken;
        return Response::json([
            'message'=>$user,
            'token'=>$token,
        ]);
    }
    public function logout()
    {
        Auth()->user()->tokens()->delete();
        return Response::json([
            'message'=>"logout Success",
            'status'=>200,
        ]);
    }
}
