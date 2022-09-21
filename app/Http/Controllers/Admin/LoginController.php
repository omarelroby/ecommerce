<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{

    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
            $cradentials = array('email' => $request->email, 'password' => $request->password);
            if (\auth()->guard('admin')->attempt($cradentials))
            {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->back()->with(['error'=>'هناك خطا بالبيانات']);
    }

    public  function save(){
        //php artisan tinker
        $admin=new App\Models\Admin;
        $admin->name="omarelruby";
        $admin->email="omar@gmail.com";
        $admin->password=bcrypt('12345677');
        $admin->save();
    }


}
