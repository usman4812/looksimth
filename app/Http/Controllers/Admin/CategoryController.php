<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category_list(Request $request)
    {
        if ($request->isMethod('post')) {
            $categories = Category::query();
            $search = @$request->input("search")["value"];
            if (isset($search) && !empty($search)) {
                $categories = $categories->where(function ($q) use ($search) {
                    $q->orWhere("name", "LIKE", "%" . $search . "%");
                    $q->orWhere("status", "LIKE", "%" . $search . "%");
                });
            }
            $categories = $categories->get();
            $listing = [];
            foreach ($categories as $key => $category) {
                $editButton = '';
                if (auth()->user()->can('edit categories')) {
                    $editButton = '<a href="' . route('category.edit', ['id' => $category->id]) . '" class="btn main-primary-color btn-active-color-primary btn-sm px-4 me-2 wrap-all-style"><i class="fa-solid fa-pen"></i>Edit</a>';
                }
                $deleteButton = '';
                if (auth()->user()->can('delete categories')) {
                    $deleteButton = '<a href="' . route('category.delete', ['id' => $category->id]) . '"   data-id="' . $category->id . '" class="btn main-warning-color delete-btn btn-active-color-danger btn-sm px-4 me-5 wrap-all-style"><i class="fa-solid fa-trash"></i>Delete</a>';
                }
                $categoryStatus = '';
                if ($category->status == 1) {
                    $categoryStatus = '<span class="badge badge-primary badge-style">Active</span>';
                } else {
                    $categoryStatus = '<span class="badge badge-danger badge-style">In-active</span>';
                }

                $listing[] = [
                    '<div class="d-flex align-items-center justify-content-center">
                        <div class="symbol symbol-50px me-5 ms-5">
                            <span class="symbol-label bg-light" style="display: flex; justify-content: center; align-items: center; height: 70px; width: 70px;">
                                <img src="' . asset('storage/public/web_assets/media/category/' . $category->image) . '"
                                style="height: 100%; width: auto; object-fit: cover;" alt=""/>
                            </span>
                        </div>
                    </div>',
                    '<div>' . $category->name . '</div>',
                    $categoryStatus,
                    $editButton . " " . $deleteButton
                ];
            }
            return response()->json([
                "data" => $listing
            ]);
        } else {
            $data['title'] = 'Category - List';
            $data['meta_desc'] = 'Category Description';
            $data['keyword'] = '';
            return view('admin.category.list')->with([
                'data' => $data
            ]);
        }
    }

    public function add_category(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
            ]);
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/category', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            $category = Category::create([
                'name' => $request->name,
                'status' => $request->status ?? 0,
                'image' => $imageName
            ]);
            if ($category) {
                return redirect()->route('category')->with('success', 'Category added successfully');
            } else {
                return redirect()->route('category')->with('error', 'Something went wrong.');
            }
        } else {
            $data['title'] = 'Add - Category';
            $data['meta_desc'] = 'Add Category Description';
            $data['keyword'] = '';
            return view('admin.category.add')->with([
                'data' => $data
            ]);
        }
    }

    public function edit_category(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string',
            ]);
            $category = Category::where('id', $id)->first();
            $imageName = '';
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|file|mimes:jpeg,jpg,png,webp'
                ]);
                $image = $request->file('image');
                $fileName = $image->getClientOriginalName();
                $filePath  = $image->storeAs('public/web_assets/media/category', $fileName, 'public');
                $imageName = basename($filePath);
            } else {
                $imageName = 'blank.png';
            }
            if ($category) {
                $category->name = $request->name;
                $category->status = $request->status;
                if ($imageName != 'blank.png') {
                    $category->image = $imageName;
                }
                $category->save();
                return redirect()->route('category')->with('success', 'Category updated successfully');
            } else {
                return redirect()->route('category')->with('error', 'Category not found.');
            }
        } else {
            $category = Category::Find($id);
            $data['title'] = 'Update - Category';
            $data['meta_desc'] = 'Update Category Description';
            $data['keyword'] = '';
            return view('admin.category.edit')->with([
                'data' => $data,
                'category' => $category
            ]);
        }
    }


    public function delete_category($id) {
       $category = Category::where('id', $id)->first();
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ], 404);
        }
       $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);

    }
}
