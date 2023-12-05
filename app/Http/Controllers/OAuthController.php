<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    public function handleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return redirect('/')->with('error', 'Failed to authenticate with the external service.');
        }

        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => config('services.igdb.client_id'),
            'client_secret' => config('services.igdb.client_secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => route('oauth.callback'),
        ]);

        if ($response->failed()) {
            return redirect('/')->with('error', 'Failed to authenticate with the external service.');
        }

        $data = $response->json();

        // Store the access token in the session
        session(['igdb_access_token' => $data['access_token']]);

        // Redirect the user to the appropriate page
        return redirect('/dashboard');
    }
}
