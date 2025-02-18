<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function service_list(Request $request)
    {

        if ($request->isMethod('post')) {
            $services = Service::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $services = $services->where(function ($q) use ($search) {
                    $q->orWhere("title", "LIKE", "%" . $search . "%");
                    $q->orWhere("price", "LIKE", "%" . $search . "%");
                });
            }
            $services = $services->with('category')->get();
            $listing = [];
            foreach ($services as $key => $service) {
                $editButton = '';
                if (auth()->user()->can('edit services')) {
                    $editButton = '<a href="' . route('service.edit', ['id' => $service->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete services')) {
                    $deleteButton = '<a href="' . route('service.delete', ['id' => $service->id]) . '"   data-id="' . $service->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }

                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                <img src="' . asset('storage/public/web_assets/media/service/' . $service->image) . '"
                                style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                            </span>
                        </div>
                    </div>',
                    '<div>' . $service->title . '</div>',
                    $service->category->name,
                    '$ ' . $service->price,
                    $service->percent ? $service->percent . '%' : 'N/A',
                    $service->discount_price !== null ? '$ ' . $service->discount_price : 'N/A',

                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Service - List';
            $data['meta_desc'] = 'Service Description';
            $data['keyword'] = '';
            return view('admin.service.list')->with([
                'data' => $data
            ]);
        }
    }


    public function add_service(Request $request)
    {

        if ($request->isMethod('post')) {
            $request->validate([
                'category_id' => 'required',
                'title' => 'required',
            ]);
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/service', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            if ($request->percent) {
                $discount_price = $request->price - ($request->price * $request->percent / 100);
            }
            $service = Service::Create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $imageName,
                'percent' => $request->percent,
                'discount_price' => $discount_price,
            ]);
            if ($service) {
                return redirect()->route('service')->with('success', 'Service added successfully');
            } else {
                return redirect()->route('service')->with('error', 'Something went wrong.');
            }
        } else {
            $categories = Category::all();
            $data['title'] = 'Service - List';
            $data['meta_desc'] = 'Service Description';
            $data['keyword'] = '';
            return view('admin.service.add')->with([
                'data' => $data,
                'categories' => $categories,
            ]);
        }
    }



    public function edit_service(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'category_id' => 'required',
                'title' => 'required',
            ]);
            $service = Service::where('id', $id)->first();
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/service', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            if ($request->percent) {
                $discount_price = $request->price - ($request->price * $request->percent / 100);
            }
            if ($service) {
                $service->title = $request->title;
                $service->category_id = $request->category_id;
                $service->price = $request->price;
                $service->description = $request->description;
                $service->percent = $request->percent;
                $service->discount_price =$discount_price;
                if ($imageName != 'blank.png') {
                    $service->image = $imageName;
                }
                $service->save();
                return redirect()->route('service')->with('success', 'Service updated successfully');
            } else {
                return redirect()->route('service')->with('error', 'Service not found.');
            }
        } else {
            $service = Service::findOrFail($id);
            $categories = Category::all();
            $data['title'] = 'Service - Update';
            $data['meta_desc'] = 'Service Description';
            $data['keyword'] = '';
            return view('admin.service.edit')->with([
                'data' => $data,
                'service' => $service,
                'categories' => $categories
            ]);
        }
    }

    public function delete_service($id)
    {
        $service = Service::where('id', $id)->first();
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found.'
            ], 404);
        }
        $service->delete();
        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.'
        ]);
    }
}
