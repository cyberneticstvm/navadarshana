<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    function authenicate(Request $request)
    {
        $credentials = array('email' => $request->json('email'), 'password' => $request->json('password'));
        $user = null;
        if ($user):
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        endif;
    }
}
