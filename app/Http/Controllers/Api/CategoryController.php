<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable',
            'limit' => 'nullable',
            'featured' => 'nullable',
        ]);

        $search = $request->get('search');
        $featured = $request->get('featured');
        $limit = $request->get('limit') ?? 15;
        $qry = Category::select('*');
        if (!empty($search)) {
            $qry->where('name', 'LIKE', '%' . $search . '%');
        }
        if (!empty($featured)) {
            $qry->where('featured', $featured);
        }
        if ($limit == 'all') {
            $category = $qry->get();
        } else {
            $category = $qry->paginate($limit);
        }
        $rows = CategoryResource::collection($category);
        return $rows;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return new CategoryResource($category);
        } else {
            return response()->json([], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
