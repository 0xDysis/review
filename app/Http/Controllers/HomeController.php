<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required_with:new_password', 'nullable', 'password'],
            'new_password' => ['required_with:current_password', 'nullable', 'confirmed', 'min:8'],
            'profile_pic' => 'image|max:2048',
            'banner' => 'image|max:2048',
        ]);
        
        $user = Auth::user();
    
        // Check if the current password is correct
        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
    
        // Update the password
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
    
        // Update the profile picture
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $user->profile_pic = $path;
        }
    
        // Update the banner
        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banners', 'public');
            $user->banner = $path;
        }
    
        $user->save();
    
        return back()->with('success', 'Profile updated successfully.');
    }
    
}



