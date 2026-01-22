<?php

namespace Modules\Tourism\Http\Controllers\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tourism\Models\Tourism;

class TourismController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tourisms = Tourism::where('status', 1)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('intro', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(9);

        return view('tourism::frontend.index', compact('tourisms', 'search'));
    }

    /**
     * Show the specified resource.
     * @param string $slug
     * @return Renderable
     */
    public function show($slug)
    {
        $tourism = Tourism::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('tourism::frontend.show', compact('tourism'));
    }
}
