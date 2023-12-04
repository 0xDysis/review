<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!Auth::user()->hasVerifiedEmail()) {
            return $request->user()->emailVerificationPrompt();
        }

        // Your dashboard logic here

        return view('dashboard');
    }
}
