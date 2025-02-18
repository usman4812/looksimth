<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Jobs\SendOtpJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ForgotPasswordController extends Controller
{
    //forget password
    public function forgetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required']
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->otp = randomNumber();
            $user->save();
            $details = $user;
            dispatch(new SendOtpJob($details));

            $response = [
                'status' => 'success',
                'message' => 'We have send message in youe Email',
            ];

            return response()->json($response, 200);
        } else {
            return response()->json(422);
        }
    }

    //reset password after forget
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
            'c_password' => 'required|same:password',
            'email' => ['required'],
            'otp' => ['required'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::where('otp', $request->otp)
            ->where('email', $request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->otp = null;
            $user->save();
            $response = [
                'status' => 'success',
                'message' => 'Forget Password Successfully',
            ];
            return response()->json($response, 201);
        } else {
            return response()->json(422);
        }
    }
}
