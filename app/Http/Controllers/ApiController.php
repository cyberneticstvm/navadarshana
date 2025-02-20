<?php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    function authenicate(Request $request)
    {
        $credentials = array('email' => $request->json('email'), 'password' => $request->json('password'));
        $user = null;
        if (Auth::attempt($credentials)):
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
        endif;
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

    function getStudentSyllabuses()
    {
        $syllabuses = Syllabus::orderBy('name')->get();
        if ($syllabuses):
            return response()->json([
                'status' => true,
                'syllabuses' => $syllabuses,
                'message' => 'success',
            ], 200);
        else:
            return response()->json([
                'status' => false,
                'syllabuses' => null,
                'message' => 'Invalid Credentials',
            ], 401);
        endif;
    }
}
