<?php

namespace App\Http\Controllers\API;

use Laravel\Passport\ClientRepository;
use App\Http\Controllers\Controller;

class ApiKeyController extends Controller
{
    protected $clients;

    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }

    public function createApiKey()
    {
        $client = $this->clients->create(
            null,  // user_id, none for client credentials
            'My Client Name',  // name
            ''  // redirect URI, none for client credentials
        );

        return response()->json([
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ]);
    }
}
