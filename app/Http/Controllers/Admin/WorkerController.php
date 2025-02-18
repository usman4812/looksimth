<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    public function worker_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $workers = User::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $workers = $workers->where(function ($q) use ($search) {
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                    $q->orWhere("email", "LIKE", "%" . $search . "%");
                });
            }
            $workers = $workers->with('service')->latest()->get();
            $listing = [];
            foreach ($workers as $key => $worker) {
                $editButton = '';
                if (auth()->user()->can('edit workers')) {
                    $editButton = '<a href="' . route('worker.edit', ['id' => $worker->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete workers')) {
                    $deleteButton = '<a href="' . route('worker.delete', ['id' => $worker->id]) . '"   data-id="' . $worker->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $workerStatus = '';
                if ($worker->status == 1) {
                    $workerStatus = '<span class="badge badge-primary badge-style">Active</span>';
                } else {
                    $workerStatus = '<span class="badge badge-danger badge-style">In-active</span>';
                }

                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                <img src="' . asset('storage/public/web_assets/media/worker/' . $worker->image) . '"
                                style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                            </span>
                        </div>
                    </div>',
                    '<div>' . $worker->name . '</div>',
                    $worker->email,
                    $worker->phone,
                    $worker->address,
                    $worker->gender,
                    @$worker->service->title ?? 'N/A',
                    $workerStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Worker - List';
            $data['meta_desc'] = 'Worker Description';
            $data['keyword'] = '';
            return view('admin.worker.list')->with([
                'data' => $data
            ]);
        }
    }



    public function add_worker(Request $request)
    {
        if ($request->isMethod('Post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|email:rfc,dns',
                'service_id' => 'required',
                'password'    => 'required|string|min:8|confirmed',
            ]);
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/worker', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            $worker  = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
                'status' => $request->status,
                'service_id' => $request->service_id,
                'password' =>  Hash::make($request->password),
                'image' => $imageName,
            ]);
            $worker->assignRole('Worker');
            if ($worker) {
                return redirect()->route('worker')->with('success', 'Worker added successfully');
            } else {
                return redirect()->route('worker')->with('error', 'Something went wrong.');
            }
        } else {
            $services = Service::select('id', 'title')->get();
            $data['title'] = 'Worker - Add';
            $data['meta_desc'] = 'Worker Description';
            $data['keyword'] = '';
            return view('admin.worker.add')->with([
                'data' => $data,
                'services' => $services
            ]);
        }
    }


    public function edit_worker(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $worker = User::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|email:rfc,dns|unique:users,email,' . $worker->id,
                'service_id' => 'required',
            ]);
            if ($request->password) {
                $request->validate([
                    'password' => ['string', 'min:8', 'confirmed'],
                ]);
                $worker->password = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/worker', $fileName, 'public');
                $worker->image = basename($filePath);
            }
            $worker->name = $request->name;
            $worker->email = $request->email;
            $worker->phone = $request->phone;
            $worker->address = $request->address;
            $worker->service_id = $request->service_id;
            $worker->gender = $request->gender;
            $worker->status = $request->has('status') ? 1 : 0;
            $worker->save();
            return redirect()->route('worker')->with('success', 'Worker updated successfully');
        } else {
            $worker = User::findOrFail($id);
            $services = Service::select('id', 'title')->get();
            $data['title'] = 'Worker - Update';
            $data['meta_desc'] = 'Worker Description';
            $data['keyword'] = '';
            return view('admin.worker.edit')->with([
                'data' => $data,
                'worker' => $worker,
                'services' => $services
            ]);
        }
    }



    public function delete_worker($id) {
        $worker = User::findOrFail($id);
        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'worker not found.'
            ], 404);
        }
       $worker->delete();
        return response()->json([
            'success' => true,
            'message' => 'worker deleted successfully.'
        ]);
    }
}
