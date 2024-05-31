<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email|required',
            'name' => 'required',
            'password' => 'required|confirmed'
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // $tokenResult = $user->createToken('Personal Access Token');

        // $token = $tokenResult->plainTextToken;


        $userRole = Role::where('name', 'user')->first();

        $user->assignRole($userRole);

        return response([
            'message' => 'Register Success',
            // 'user' => $user,
            // 'token' => $token
        ], 200);
    }
}
