<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AdminController extends Controller
{
    public function dashboard() {
        // dd(FacadesRequest::segments());
        $data['title'] = 'Dashboard';
        $data['meta_desc'] = 'Dashboard Description'; 
        $data['keyword'] = 'asd, das, qwe123';
        return view('admin.pages.dashboard')->with([
            'data' => $data,
        ]);
    }   
}
