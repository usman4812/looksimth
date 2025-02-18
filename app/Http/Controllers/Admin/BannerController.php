<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $banners = Banner::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $banners = $banners->where(function ($q) use ($search) {
                    $q->orWhere("url", "LIKE", "%" . $search . "%");
                });
            }
            $banners = $banners->get();
            $listing = [];
            foreach ($banners as $key => $banner) {
                $editButton = '';
                if (auth()->user()->can('edit banners')) {
                    $editButton = '<a href="' . route('banner.edit', ['id' => $banner->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete banners')) {
                    $deleteButton = '<a href="' . route('banner.delete', ['id' => $banner->id]) . '"   data-id="' . $banner->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                <img src="' . asset('storage/public/web_assets/media/banner/' . $banner->image) . '"
                                style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                            </span>
                        </div>
                    </div>',
                    '<a href="' . $banner->url . '" target="_blank">' . $banner->url . '</a>',
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Banner - List';
            $data['meta_desc'] = 'Banner Description';
            $data['keyword'] = '';
            return view('admin.banner.list')->with([
                'data' => $data
            ]);
        }
    }


    public function add_banner(Request $request) {
        if ($request->isMethod('post')) {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,jpg,png,webp',
                'url' => 'required|url',
            ]);
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/banner', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            $banner = Banner::create([
                'url' => $request->url,
                'image' => $imageName
            ]);
            if ($banner) {
                return redirect()->route('banner')->with('success', 'Banner added successfully');
            } else {
                return redirect()->route('banner')->with('error', 'Something went wrong.');
            }
        }else{
            $data['title'] = 'Add - Banner';
            $data['meta_desc'] = 'Add Banner Description';
            $data['keyword'] = '';
            return view('admin.banner.add')->with([
                'data' => $data
            ]);
        }
    }


    public function edit_banner(Request $request, $id) {
        if ($request->isMethod('post')) {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,jpg,png,webp',
                'url' => 'required|url',
            ]);
            $banner = Banner::find($id);

            $imageName =  $banner->image;
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/banner', $fileName, 'public');
                $imageName = basename($filePath);
            }

            if ($banner) {
                $banner->url = $request->url;
                $banner->image = $imageName;
                $banner->save();
            }
            if ($banner) {
                return redirect()->route('banner')->with('success', 'Banner updated successfully');
            } else {
                return redirect()->route('banner')->with('error', 'Something went wrong.');
            }
        }else{
            $data['title'] = 'Edit - Banner';
            $data['meta_desc'] = 'Edit Banner Description';
            $data['keyword'] = '';
            $data['banner'] = Banner::find($id);
            return view('admin.banner.edit')->with([
                'data' => $data
            ]);
        }
    }

    public function delete_banner($id) {
        $banner = Banner::where('id', $id)->first();
        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found.'
            ], 404);
        }
       $banner->delete();
        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.'
        ]);

    }
}
