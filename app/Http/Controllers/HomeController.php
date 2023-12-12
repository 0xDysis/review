<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'current_password' => ['required_with:new_password', 'nullable', 'string', 'min:8'],
            'new_password' => ['required_with:current_password', 'nullable', 'string', 'min:8', 'confirmed'],
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
        if ($request->filled('cropped_profile_pic')) {
            $imageData = $request->cropped_profile_pic;
            $fileName = 'profile_pic_' . time() . '.png';
            $path = 'profile_pics/' . $fileName;
            Storage::disk('public')->put($path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));
            $user->profile_pic = $path;
        }

        // Update the banner
        if ($request->filled('cropped_banner')) {
            $imageData = $request->cropped_banner;
            $fileName = 'banner_' . time() . '.png';
            $path = 'banners/' . $fileName;
            Storage::disk('public')->put($path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));
            $user->banner = $path;
        }
    
        $user->save();
    
        return back()->with('success', 'Profile updated successfully.');
    }
    
}

