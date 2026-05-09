<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignupUser extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth/signup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SignupRequest $request)
    {
       $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ]);
        Auth::login($user);
      if (auth()->check() && auth()->user()->is_admin()) {
       return redirect('/admin/home')->with('success', "welcome back ".Auth::user()->name);
   }
        return redirect('/')->with('success','Welcome to Cedar Craft');
    }

}
