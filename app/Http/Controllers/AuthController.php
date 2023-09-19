<?php

namespace App\Http\Controllers;
//use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function signin() {
        return view('auth.signin');
    }

    public function authenticate(Request $request) {

        $credentials = $request->only('user_login', 'password');

        // print_r ($credentials);
        // exit;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            echo auth()->user()->id;

            $request->session()->put('LoggedUser', [
                // 'user_id' => $user->user_id,
                // 'company' => $user->company,
                // 'user_name' => $user->user_name,
                'id' => $user->id,
                'user_login' => $user->user_login,
                'email' => $user->email,
                'fullname' => $user->fullname,
                'department' => $user->department,


                // 'user_photo' => $user->user_photo
            ]);

            return redirect()->intended('/');
    }
}

        // public function perform()
        // {
        //     Session::flush();
            
        //     Auth::logout();

        //     return redirect('/login');
        // }

        public function logout(Request $request) {
            $r=$request->session()->flush();
            return redirect('/signin');
          }

    // public function logout(Request $request) {
    //     // $request->session()->forget('LoggedUser');
    //     // return redirect()->route('auth.login');
    //     $request->session()->flush();
    //     //return redirect('/login');
    //     return view('auth.signin');
        
    // }
}
