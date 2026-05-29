<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    if (Auth::attempt($request->only(['email', 'password']))) {

        $request->session()->regenerate();

        if (auth()->check() && auth()->user()->is_admin()) {
       return redirect('/admin/home')->with('success', "welcome back ".Auth::user()->name);
   }
        return redirect('/shop')->with('success', "welcome back ".Auth::user()->name);
    }

    return back()->withErrors([
        'email' => 'The provided credentials are incorrect.',
        'password' => 'The provided credentials are incorrect.',
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
       Auth::logout();
        return redirect('/');
    }
}
