<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user){
            if($user->level_id == '1'){
                return redirect()->intended('rw');
            } elseif($user->level_id == '2'){
                return redirect()->intended('rt');
            } elseif($user->level_id == '3'){
                return redirect()->intended('warga');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credential = $request->only('username', 'password');
      //  dd($credential);
        if(Auth::attempt($credential)){
            $user = Auth::user();

            if($user->level_id == '1'){
                return redirect()->intended('rw');
            } else if($user->level_id == '2'){
                return redirect()->intended('rt');
            } else if($user->level_id == '3'){
                return redirect()->intended('warga');
            }

            return redirect()->intended('/');
        }

        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }

    // public function register(){
    //     return view('register');
    // }

    // public function proses_register(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'nama' => 'required',
    //         'username' => 'required|unique:m_user',
    //         'password' => 'required'
    //     ]);

    //     if($validator->fails()){
    //         return redirect('/register')
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $request['level_id'] = '2';
    //     $request['password'] = Hash::make($request->password);

    //     UserModel::create($request->all());

    //     return redirect()->route('login');
    // }

    public function logout(Request $request){
        $request->session()->flush();

        Auth::logout();

        return Redirect('login');
    }


}