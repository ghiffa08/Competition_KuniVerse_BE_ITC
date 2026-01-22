<?php

namespace Modules\ProductCategory\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\ProductCategory\Models\ProductCategory;

class ProductCategoriesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'ProductCategories';

        // module name
        $this->module_name = 'productcategories';

        // directory path of the module
        $this->module_path = 'productcategory::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\ProductCategory\Models\ProductCategory";
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $validated_data = $request->validate([
            'name'        => 'required|max:191',
            'slug'        => 'nullable|max:191',
            'description' => 'nullable',
            'status'      => 'required|integer',
        ]);

        $$module_name_singular = $module_model::create($validated_data);

        flash("New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
        );

        return redirect("admin/{$module_name}");
    }


    /**
     * Display the specified resource.
     */
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);

        $selectOptions = ProductCategory::pluck('name', 'id');

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
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
                    'selectOptions'
                ),
                [ $module_name_singular => $$module_name_singular ] // <-- ini menambahkan $umkmproduct
            )
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_path  = $this->module_path;
        $module_icon  = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $$module_name_singular = $modutRequeste_model::findOrFail($id);

        $$module_name_singular->update(
        $request->except(['_token', '_method'])
    );


        flash(
            Str::singular($module_title)."' Updated Successfully"
        )->success()->important();

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$$module_name_singular->id
        );

        return redirect()->route(
            "backend.{$module_name}.show",
            $$module_name_singular->id
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name  = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Destroy';

        $$module_name_singular = $module_model::findOrFail($id);
        $$module_name_singular->delete();

        flash(
            Str::singular($module_title)."' Deleted Successfully"
        )->success()->important();

        logUserAccess(
            $module_title.' '.$module_action.' | Id: '.$id
        );

        return redirect("admin/{$module_name}");
    }

}
