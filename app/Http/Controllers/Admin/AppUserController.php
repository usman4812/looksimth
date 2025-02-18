<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppUserController extends Controller
{
    public function app_user_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $users = User::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $users = $users->where(function ($q) use ($search) {
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                    $q->orWhere("email", "LIKE", "%" . $search . "%");
                });
            }
            $users = $users->latest()->get();
            $listing = [];
            foreach ($users as $key => $user) {
                // $editButton = '';
                // if (auth()->user()->can('edit users')) {
                //     $editButton = '<a href="' . route('worker.edit', ['id' => $worker->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                // }
                $deleteButton = '';
                if (auth()->user()->can('delete users')) {
                    $deleteButton = '<a href="' . route('user.delete', ['id' => $user->id]) . '"   data-id="' . $user->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $userstatus = '';
                if ($user->status == 1) {
                    $userstatus = '<span class="badge badge-primary badge-style">Active</span>';
                } else {
                    $userstatus = '<span class="badge badge-danger badge-style">In-active</span>';
                }

                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                <img src="' . asset('storage/public/web_assets/media/user/' . $user->image) . '"
                                style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                            </span>
                        </div>
                    </div>',
                    '<div>' . $user->name . '</div>',
                    $user->email,
                    $user->phone,
                    $user->address,
                    $user->gender,
                    $user->service->title,
                    $userstatus,
                   $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'User - List';
            $data['meta_desc'] = 'User Description';
            $data['keyword'] = '';
            return view('admin.app_user.list')->with([
                'data' => $data
            ]);
        }
    }
}
