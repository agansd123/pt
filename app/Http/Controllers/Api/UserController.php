<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->content = array();
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['name' => $request->name, 'password' => $request->password]))
        {
            $user = Auth::user();
            $this->content['token'] = $user->createToken('Pi App')->accessToken;
            $status = 200;
        } else {

            $this->content['error'] = "未授权";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    public function passport()
    {
        return response()->json(['user' => Auth::user()]);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request -> email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['user'=>$user->email],200);
    }
}
