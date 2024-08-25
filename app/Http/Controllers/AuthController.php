<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        try{

            $data = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::Attempt($data)) {
                return redirect('/');
            }else{
                Session::flash('error', 'Email atau Password Salah');
                return redirect('/login');
            }
        }catch (\Exception $e){
            return redirect('/login')->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        return;   
    }
}
