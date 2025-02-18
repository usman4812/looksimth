<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionType;
use App\Models\Superadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function add_user(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'fname' => 'required|string',
                'email' => 'required|email|unique:superadmins,email',
                'password' => 'required|string',
                'role_id' => 'required'
            ]);
            $imageName = '';

            if ($request->hasFile('avatar')) {
                $request->validate([
                    'avatar' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('avatar');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/avatars', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            $userAdd = Superadmin::create([
                'uuid' => generate_uuid_key(),
                'name' => $request->fname . " " . $request->lname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => (isset($request->status)) ? 1 : 0,
                'avatar' => $imageName
            ]);
            if ($userAdd) {
                $role = Role::where('id', $request->role_id)->first();

                $userAdd->assignRole($role);
                return to_route('admin.users')->with('success', 'User added successfully.');
            } else {
                return to_route('admin.users')->with('error', 'Something went wrong.');
            }
        } else {
            $roles = Role::where('guard_name', 'superadmin')->get();

            $data['title'] = 'Users - Add';
            $data['meta_desc'] = 'Users Description';
            $data['keyword'] = '';
            return view('admin.pages.users.add')->with([
                'data' => $data,
                'roles' => $roles,
            ]);
        }
    }

    // Users List

    public function user_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $users = Superadmin::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $users = $users->where(function ($q) use ($search) {
                    $q->orWhere("id", "LIKE", "%" . $search . "%");
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("email", "LIKE", "%" . $search . "%");
                });
            }
            $users = $users->get();
            $listing = [];
            foreach ($users as $key => $user) {
                $editButton = '';
                if (auth()->user()->can('edit users') && auth()->user()->uuid !== $user->uuid) {
                    $editButton = '<a href="' . route('admin.user.edit', ['uuid' => $user->uuid]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete users') && auth()->user()->uuid !== $user->uuid) {
                    $deleteButton = '<a href="' . route('admin.user.delete', ['uuid' => $user->uuid]) . '" class="btn delete-btn main-warning-color btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }

                // dd($is_premium->plans->type);
                $userStatus = '';
                if ($user->status == 1) {
                    $userStatus = '<span class="badge badge-primary badge-style">Active</span>';
                } else {
                    $userStatus = '<span class="badge badge-danger">In-active</span>';
                }

                $listing[] = [
                    // ++$key,
                    '<div class="d-flex align-items-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light d-flex align-items-center">
                                <img src="' . asset('storage/public/web_assets/media/avatars/' . $user->avatar) . '"
                                    class="h-100 table-image-style" alt="" />
                            </span>
                        </div>
                        <div class="d-flex justify-content-start flex-column">
                            ' . $user->name . '
                        </div>
                    </div>',
                    $user->email,
                    '<span class="badge badge-success badge-style">' . $user->getRoleNames()->first() . '</span>',
                    $userStatus,
                    (!empty($user->last_login)) ? date('M d, Y H:i a', strtotime($user->last_login)) : ' - ',
                    $editButton . " " . $deleteButton

                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Users - List';
            $data['meta_desc'] = 'Users Description';
            $data['keyword'] = '';
            return view('admin.pages.users.list')->with([
                'data' => $data,
            ]);
        }
    }

    // Users Edit

    public function edit_user(Request $request, $uuid)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'fname' => 'required|string',
                'email' => 'required|email',
                'role_id' => 'required'
            ]);
            $imageName = '';

            if ($request->hasFile('avatar')) {
                $request->validate([
                    'avatar' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('avatar');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/avatars', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            // Update user
            $user = Superadmin::find($uuid);
            if ($user) {
                $updateData = [
                    'name' => $request->fname . " " . $request->lname,
                    'email' => $request->email,
                    'status' => (isset($request->status)) ? 1 : 0,
                    'avatar' => $imageName,
                ];
                if ($request->has('password') && !empty($request->password)) {
                    $updateData['password'] = Hash::make($request->password);
                }
                $user->update($updateData);
                $role = Role::find($request->role_id);
                if ($role) {
                    // Sync the role, this will replace any existing roles with the new one
                    $user->syncRoles([$role->name]);

                    return to_route('admin.users')->with('success', 'User updated and role assigned successfully.');
                } else {
                    return back()->with('error', 'Role not found');
                }
            } else {
                return back()->with('error', 'User not found');
            }
        } else {
            $user = Superadmin::where('uuid', $uuid)->first();
            if ($user) {
                $nameParts = explode(' ', $user->name, 2);
                $user->fname = $nameParts[0] ?? '';
                $user->lname = $nameParts[1] ?? '';
            }
            $roles = Role::where('guard_name', 'superadmin')->get();
            $data['title'] = 'Users - Edit';
            $data['meta_desc'] = 'Users Description';
            $data['keyword'] = '';
            return view('admin.pages.users.edit')->with([
                'data' => $data,
                'user' => $user,
                'roles' => $roles,
            ]);
        }
    }

    public function delete_user($uuid)
    {
        $user = Superadmin::select('uuid')->where('uuid', $uuid)->first();
        if (is_null($user)) {
            return to_route('admin.users')->with('error', 'Record Not Found.');
        } else {
            $deleteUser = Superadmin::where('uuid', $uuid)->delete();
            if ($deleteUser) {
                return to_route('admin.users')->with('success', 'User Deleted successfully.');
            } else {
                return to_route('admin.users')->with('error', 'Something went wrong.');
            }
        }
    }
    // Roles List

    public function all_roles()
    {
        $roles = array();
        $types = PermissionType::where('guard_name', 'superadmin')->select('id', 'name')->get();
        $permissions = Permission::where('guard_name', 'superadmin')->select('id', 'name', 'type')->get();

        foreach ($types as $type) {
            $cntr = 0;
            foreach ($permissions as $permi) {
                if ($type->id == $permi->type) {
                    $roles[$type->name][$cntr]['name'] = $permi->name;
                    $roles[$type->name][$cntr]['id'] = $permi->id;
                    $cntr++;
                }
            }
        }

        $rolesFromDB = Role::where('guard_name', 'superadmin')->get();

        $data['title'] = 'Admin - Roles';
        $data['meta_desc'] = 'Roles Description';
        $data['keyword'] = '';
        return view('admin.pages.roles.list')->with([
            'data' => $data,
            'roles' => $roles,
            'rolesFromDB' => $rolesFromDB
        ]);
    }
    public function add_admin_role(Request $request)
    {

        $request->validate([
            "name" => "required|string",
            // "permissions" => "required|array",
            // 'permissions.*' => 'required|string'
        ]);
        // dd($request);
        $roles = Role::create(['name' => $request->name, 'guard_name' => 'superadmin']);
        if ($roles) {
            $roles->givePermissionTo($request->permissions);
            return redirect()->route('admin.roles')->with('success', 'Role Created successfully.');
        } else {
            return redirect()->route('admin.roles')->with('error', 'Something Went Wrong.');
        }
    }
    public function update_admin_role(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',

        ]);
        $dataU = [
            'name' => $request->name
        ];

        $role = Role::where('id', $id)->update($dataU);
        if ($role) {
            $getRole = Role::where('id', $id)->first();
            $getRole->syncPermissions([]);
            $getRole->givePermissionTo($request->permissions);
            return redirect()->route('admin.roles')->with('success', 'Role Updated successfully.');
        } else {
            return redirect()->route('admin.roles')->with('error', 'Something Went Wrong.');
        }
    }
    public function delete_admin_role($id)
    {
        $getRole = Role::where('id', $id)->first();
        if (!$getRole) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ], 404);
        }
        $getRole->syncPermissions([]);
        $deleted = $getRole->delete();
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ], 500);
        }
    }

    // public function delete_admin_role($id)
    // {
    //     $getRole = Role::where('id', $id)->first();
    //     if (empty($getRole)) {
    //         return redirect()->route('admin.roles')->with('error', 'Record Not Found');
    //     }
    //     $getRole->syncPermissions([]);
    //     $getRole->delete();
    //     if ($getRole) {
    //         return redirect()->route('admin.roles')->with('success', 'Role Deleted Successfully.');
    //     } else {
    //         return redirect()->route('admin.roles')->with('error', 'Something Went Wrong.');
    //     }
    // }

    // Driver Numbers
    public function driver_number()
    {
        $data['title'] = 'Driver Numbers - Assign';
        $data['meta_desc'] = 'Driver Numbers Description';
        $data['keyword'] = '';
        return view('admin.pages.users.driver')->with([
            'data' => $data
        ]);
    }
}
