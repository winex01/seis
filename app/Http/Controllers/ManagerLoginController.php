<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use Illuminate\Support\Facades\Hash;
use Session;



class ManagerLoginController extends Controller
{
    //
    public function showLoginForm()
    {
    	return view('auth.manager.managerlogin');
    }

    public function login(Request $request)
    {
    	// validate
    	$this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // check user
        $check = Manager::where('active', 1)
        				->where('username', $request->username)
        				->first();

        if ($check) {
        	if (Hash::check($request->password, $check->password)) {
			    // The passwords match...
			    $request->session()->put('manager_id', $check->id);
                return redirect()->route('managerHome.home');
			}else{
			    // invalid pass
			    flash('Warning: Invalid password')->error();
			}
        }else{
        	// invalid username
        	 flash('Warning: Invalid username')->error();
        }

        return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('manager_id');
        session()->forget('manager_id');
        Session::flush();
        return redirect()->route('managerLogin');
    }

    
}
