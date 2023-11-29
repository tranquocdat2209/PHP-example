<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function getUserId(){
        $user =  \auth()->user()->id;
        return User::query()->get()->only($user);
    }
    public function index()
    {
        return view('admin.dashboard.main', [
            'title' => 'Trang chủ',
            'items' => $this->getUserId()
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function changePassword()
    {
        return view('admin.change-password',[
        ]);
    }

    public function updatePassword(Request $request)
    {
       $request->validate([
           'old_password' => 'required',
           'new_password' => 'required|confirmed',
       ]);

       // Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Mật khẩu không chính xác!");
        }

        //Update the new Password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
         return back()->with("success", "Thay đổi mật khẩu thành công");
    }

    public function myAccount(){
        return view('admin.my-account',[
            'title'=> 'My Account',
            'items' => $this->getUserId()
        ]);
    }
}
