<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login', [
            'title' => 'Admin',
        ]);
    }

    public function authenticate(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validate->passes()){
            if(Auth::guard('admin')->attempt(
                ['email'=> $request-> email, 'password'=> $request-> password])){
                    $admin = Auth::guard('admin')->user();
                    if($admin->role == 2){
                        return redirect()->route('admin.dashboard');
                    }else{
                        Auth::guard('admin')->logout();
                        return redirect()->route('admin.login')->with('error','Bạn không có quyền truy cập vào admin');
                    }
            }else{
                return redirect()->route('admin.login')->with('error','Tài khoản hoặc mật khẩu không chính xác');
            }
        }else{
            return redirect()->route('admin.login')
                ->withErrors($validate)
                ->withInput($request->only('email'));
        }
    }

}
