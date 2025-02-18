<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validate = $request->validate([
            'search' => 'nullable',
            'limit' => 'nullable',
        ]);

        $search = $request->get('search');
        $limit = $request->get('limit') ?? 15;

        $qry = Service::select('*');
        if (!empty($search)) {
            $qry->where('title', 'LIKE', '%' . $search . '%');
            $qry->where('category_id', 'LIKE', '%' . $search . '%');
        }
        if ($limit == 'all') {
            $services = $qry->get();
        } else {
            $services = $qry->paginate($limit);
        }
        $rows = ServiceResource::collection($services);
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
        $service = Service::find($id);
        if ($service) {
            return new ServiceResource($service);
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

    public function addFavouritService(Request $request)
    {
        $user = auth()->user();
        $serviceId = $request->input('service_id');
        if (!$user->services()->where('service_id',  $serviceId)->exists()){
            $user->services()->syncWithoutDetaching($serviceId);
            return response()->json(['message'=>'store successfully!'], 200);
        }
        else{
            $user->services()->detach($serviceId);
            return response()->json(['message'=>'removed from favourit successfully']);
        }

    }

    public function getUserFavouritServices(){
        $user = auth()->user();
        $userService = $user->services()->get();
        return ServiceResource::collection($userService);

    }
}
