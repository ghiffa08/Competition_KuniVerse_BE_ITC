<?php

namespace Modules\Umkm\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\ProductCategory\Models\ProductCategory;

class UmkmsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Umkms';

        // module name
        $this->module_name = 'umkms';

        // directory path of the module
        $this->module_path = 'umkm::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Umkm\Models\Umkm";
    }

        public function index()
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        // DATA LIST (JANGAN TIMPA $module_name)
        $$module_name = $module_model::latest()->paginate(10);

        return view(
                "$module_path.$module_name.index",
            compact(
                'module_title',
                'module_name',
                'module_icon',
                'module_action',
                'module_name_singular',
                "$module_name"
            )
        );
    }

    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        $selectOptions = ProductCategory::pluck('name', 'id');

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', 'selectOptions')
        );
    }


    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        // ✅ VALIDASI
        $validated_data = $request->validate([
            'name' => 'required|max:191',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'slug' => 'nullable|max:191',
            'status' => 'required|integer',

            // 🔥 VALIDASI GAMBAR
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ UPLOAD GAMBAR (NAMA FILE ACAK)
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'umkmproducts',
                $filename,
                'public'
            );

            $validated_data['image_url'] = $path;
        }

        // ❌ buang field "image" supaya tidak ikut create()
        unset($validated_data['image']);

        // ✅ SIMPAN DATA
        $$module_name_singular = $module_model::create($validated_data);

        flash("New '".Str::singular($module_title)."' Added")
            ->success()
            ->important();

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
        );

        return redirect("admin/{$module_name}");
    }

    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
        );

        return view(
            "{$module_path}.{$module_name}.show",
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_name_singular',
                'module_action',
                $module_name_singular
            )
        );
    }

    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $umkm = $module_model::findOrFail($id);

        $selectOptions = ProductCategory::pluck('name', 'id');

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$umkm->id
        );

        return view(
            "{$module_path}.{$module_name}.edit",
            array_merge(
                compact(
                    'module_title', 
                    'module_name', 
                    'module_path', 
                    'module_icon', 
                    'module_action', 
                    'selectOptions',
                    'umkm'
                ), // <-- ini menambahkan $umkmproduct
            )
        );

    }

    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        // Ambil data lama
        $$module_name_singular = $module_model::findOrFail($id);

        // ✅ VALIDASI
        $validated_data = $request->validate([
            'name' => 'required|max:191',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'slug' => 'nullable|max:191',
            'status' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ UPLOAD GAMBAR
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('umkmproducts', $filename, 'public');
            $validated_data['image_url'] = $path;
        }

        if (!empty($$module_name_singular->image_url) && Storage::disk('public')->exists($$module_name_singular->image_url)) {
            Storage::disk('public')->delete($$module_name_singular->image_url);
        }

        unset($validated_data['image']);

        // ✅ UPDATE DATA
        $$module_name_singular->update($validated_data);

        // ✅ FLASH MESSAGE (PERBAIKAN SYNTAX)
        flash(Str::singular($module_title) . ' Updated')
            ->success()
            ->important();

        logUserAccess(
            $module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id
        );

        return redirect("admin/{$module_name}");
    }

    
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Delete';

        // Ambil data
        $$module_name_singular = $module_model::findOrFail($id);

        // Hapus gambar lama jika ada
        if (!empty($$module_name_singular->image_url) && Storage::disk('public')->exists($$module_name_singular->image_url)) {
            Storage::disk('public')->delete($$module_name_singular->image_url);
        }

        // Hapus data
        $$module_name_singular->delete();

        // Flash message
        flash(Str::singular($module_title) . ' Deleted')
            ->success()
            ->important();

        // Log
        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
        );

        return redirect("admin/{$module_name}");
    }
}
