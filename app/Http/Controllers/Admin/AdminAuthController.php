<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Superadmin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminAuthController extends Controller
{
    public function admin_login(Request $request){
        
        if ($request->isMethod('post')) {
            
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            $user = Superadmin::where('email', $request->email)->first();

            if ($user && $user->status == 1) {
                $credentials = $request->only('email', 'password');
            
                $checkLogin = auth()->guard('superadmin')->attempt($credentials,'');
                
                if (!$checkLogin) {
                    return redirect()->route("admin.login")->with("error","Incorrect email or password.");
                }
                else
                {
                    Superadmin::where('uuid', auth('superadmin')->user()->uuid)->update([
                        'last_login' => Carbon::now()
                    ]);
                    return Redirect::to('/');
                }
            }
            else
            {
                return redirect()->route("admin.login")->with("error","Incorrect email or password.");
            }
            
        }
        else
        {
            $title = 'Admin - Login';
            return view('admin.auth.login')->with([
                'title' => $title
            ]);
        }

    }
    public function user_login(Request $request){
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        
            $credentials = $request->only('email', 'password');
            
            $checkLogin = auth()->attempt($credentials,'');
            
            if (!$checkLogin) {
                return redirect()->route("login")->with("error","Incorrect email or password.");
            }
            else
            {
                return Redirect::to('/user');
            }
        }

        $title = 'User - Login';

        return view('user.auth.login')->with([
            'title' => $title
        ]);
    }
    public function logout(Request $request)
    {
        if (Auth::guard('superadmin')->check()) {

            // RepLoggedTime::create([
            //     'rep_id' => auth()->user()->id,
            //     'login_time' => auth()->user()->last_login,
            //     'logout_time' => $request->cur_time,
            //     'total_time' => $request->user_time_total,
            // ]);
                        
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('success', 'Admin Logged out');
        }
        else{

            Auth::logout();
            return redirect()->route('login')->with('success', 'User Logged out');
        }
    }
}
