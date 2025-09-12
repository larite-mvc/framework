<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Lumite\Support\Auth;
use Lumite\Support\Request;
use Lumite\Support\Facades\Validator;

class controllername extends Controller
{

    public function register()
    {
        return view('auth/register');
    }

  	public function save(Request $request)
    {
        $validation = Validator::validate($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if($validation->fails()) {
            return redirect()->backwithErrors($validation->errors());
        }

        User::create([
            'name' => $request->post('name'),
            'email'=> $request->post('email'),
            'password' => Auth::Hash($request->post('password')),
        ]);

        Auth::attempt([
            'email' => $request->post('email'),
            'password' => $request->post('password')
        ]);

        return redirect(home());
  	}
}
