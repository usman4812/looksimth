<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{
    public function  register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'nullable',
            'type' => 'required|string',
            'about' => 'nullable',
            'device_token' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'about' => $request->about,
            'device_token' => $request->device_token,
            'password_confirmation' => $request->password_confirmation,

        ]);
        $user->assignRole($request->type);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => $data,
            'detail' => new UserResource($user),
        ];

        return response()->json($response, 201);
    }

    public function  login(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
            'detail' => new UserResource($user),

        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $user  =  auth()->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User is logged out successfully'
            ], 200);
        }
        return response([
            'message' => 'No authenticated user'
        ], 401);
    }
}
