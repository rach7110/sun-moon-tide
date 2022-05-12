<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function create(Request $request)
    {
        // BUG : null user.
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    }
}
