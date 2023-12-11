<?php

namespace App\Http\Controllers;

use Laravel\Passport\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function toggleToken(Request $request, $tokenId)
    {
        // Find the token
        $token = Token::find($tokenId);

        // Check if the token is revoked
        if ($token->revoked) {
            // If the token is revoked, restore it
            $token->revoked = false;
        } else {
            // If the token is not revoked, revoke it
            $token->revoked = true;
        }

        // Save the token
        $token->save();

        return response()->json(['message' => 'Token status updated'], 200);
    }
}
