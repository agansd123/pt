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
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $this->content['token'] = $user->createToken('Pi App')->accessToken;
            $status = 200;
        } else {
            $this->content['error'] = "授权失败，请检查邮箱密码";
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

    //登出
    public function logout()
    {
        //客户端退出后并清除记录在 oauth_access_tokens 表中的记录
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }

        return response()->json(['msg'=>'您已成功退出！'],200);
    }
}
