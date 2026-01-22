<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('merchant')) {
            $merchantId = auth()->id();
            $data['wisata_count'] = \Modules\Tourism\Models\Tourism::where('created_by', $merchantId)->where('type', 'wisata')->count();
            $data['kuliner_count'] = \Modules\Tourism\Models\Tourism::where('created_by', $merchantId)->where('type', 'kuliner')->count();
            $data['umkm_count'] = \Modules\Tourism\Models\Tourism::where('created_by', $merchantId)->where('type', 'umkm')->count();
            
            return view('backend.index', $data);
        }

        // Admin Data
        $data['user_count'] = \App\Models\User::count();
        $data['wisata_count'] = \Modules\Tourism\Models\Tourism::where('type', 'wisata')->count();
        $data['kuliner_count'] = \Modules\Tourism\Models\Tourism::where('type', 'kuliner')->count();
        $data['umkm_count'] = \Modules\Tourism\Models\Tourism::where('type', 'umkm')->count();
        $data['recent_users'] = \App\Models\User::latest()->take(5)->get();

        return view('backend.index', $data);
    }
}
