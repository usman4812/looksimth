<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function show()
    {
        $user =  auth()->user();
        $workerCashTotal = Booking::where('worker_id', $user->id)->whereNotNull('worker_cash')->sum('worker_cash');
        return (new UserResource($user))->additional(['worker_cash_total' => $workerCashTotal]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ]);
        $requestData= $request->except(['_token']);
        $user = User::findOrFail(auth()->user()->id);
        if (!empty($requestData['password'])) {
            $validated = $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $requestData['password'] = bcrypt($requestData['password']);
        } else {
            unset($requestData['password']);
        }
        unset($requestData['image']);
        if($request->hasFile('image')){
            $requestData['image']=storeFile(request('image'), 'storage/user');
        }

        $user->update($requestData);
        return new UserResource( $user);
    }
}
