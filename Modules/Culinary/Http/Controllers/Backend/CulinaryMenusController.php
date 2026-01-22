<?php

namespace Modules\Culinary\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Modules\Culinary\Models\Culinary;
use Modules\Culinary\Models\CulinaryMenu;
use Illuminate\Http\Request;

class CulinaryMenusController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Culinary Menus';

        // module name
        $this->module_name = 'culinary_menus';

        // directory path of the module
        $this->module_path = 'culinary::backend';

        // module icon
        $this->module_icon = 'fa-solid fa-utensils';

        // module model name, path
        $this->module_model = "Modules\Culinary\Models\CulinaryMenu";
    }

    public function index(Request $request, $culinary_id)
    {
        $culinary = Culinary::findOrFail($culinary_id);
        $menus = $culinary->menus()->orderBy('sort_order')->get();

        return view('culinary::backend.menus.index', compact('culinary', 'menus'));
    }

    public function store(Request $request, $culinary_id)
    {
        $culinary = Culinary::findOrFail($culinary_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|in:makanan,minuman,cemilan',
        ]);

        $culinary->menus()->create($request->all());

        return redirect()->back()->with('flash_success', 'Menu added successfully');
    }

    public function update(Request $request, $culinary_id, $id)
    {
        $menu = CulinaryMenu::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|in:makanan,minuman,cemilan',
        ]);

        $menu->update($request->all());

        return redirect()->back()->with('flash_success', 'Menu updated successfully');
    }

    public function destroy($culinary_id, $id)
    {
        $menu = CulinaryMenu::findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('flash_success', 'Menu deleted successfully');
    }
}
