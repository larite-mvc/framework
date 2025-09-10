<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Lumite\Support\Auth;
use Lumite\Support\Request;
use Lumite\Support\Validation\Validator;

class controllername extends Controller
{

    public function index()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $validation = Validator::validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validation->fails()){
            return redirect()->backWithErrors($validation->errors());
        }

        if (Auth::attempt([
            'email' => $request->post('email'),
            'password'=>$request->post('password')
        ])) {
            return redirect(home());
        }
        return redirect()->backWith('error','credentials did not match with our record');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

}
