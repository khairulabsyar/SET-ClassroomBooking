<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Generate token for teacher
     */
    public function login(Request $request)
    {
        // want the password & username
        // validate the input from user
        $data = $request->validate([
            'name' => 'required|string|min:5',
            'password' => 'required|string',
        ]);

        // cross check with table exists
        $teacher = Teacher::where('name', $data['name'])->first(); // get the first row of the search
        // dd($data, $data['password'], $teacher->password, Hash::check($data['password'], $teacher->password));

        if ($teacher && Hash::check($data['password'], $teacher->password)) {

            // generate token
            $token = $teacher->createToken('API Token')->plainTextToken;

            // return token to user
            return response()->json([
                'message' => 'Success login',
                'data' => [
                    'token' => $token
                ]
            ]);
        }

        abort(404, 'Teacher not registered'); // shortform for invalid teacher name
        // or
        // return response()->json([
        //     'message' => ' Teacher not registered'
        // ], 404);
    }

    /*
     * for logout purposes
     */
    public function logout()
    {
        // dd(Auth::user()->tokens->last());
        Auth::user()->tokens->last()->delete();

        return "Success logout";
    }
}