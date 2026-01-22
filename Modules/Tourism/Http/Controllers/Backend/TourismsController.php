<?php

namespace Modules\Tourism\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class TourismsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Tourisms';

        // module name
        $this->module_name = 'tourisms';

        // directory path of the module
        $this->module_path = 'tourism::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Tourism\Models\Tourism";
    }

    /**
     * Override callAction to set module_name dynamically based on route.
     * This ensures all inherited methods (index, edit, destroy, etc.) use the correct route name.
     */
    public function callAction($method, $parameters)
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
            $this->module_name = $type;
            $this->module_title = ucfirst($type);
        }
        
        return parent::callAction($method, $parameters);
    }

    private function getTypeFromRoute()
    {
        $routeName = request()->route()->getName();
        if (str_contains($routeName, 'wisata')) return 'wisata';
        if (str_contains($routeName, 'kuliner')) return 'kuliner';
        if (str_contains($routeName, 'umkm')) return 'umkm';
        
        return request('type'); // Fallback
    }

    public function index_data()
    {
        $type = $this->getTypeFromRoute();
        
        // Dynamically set module name for the view (Action Buttons)
        if($type) {
            $this->module_name = $type;
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;

        $query = $module_model::select('id', 'name', 'type', 'updated_at', 'status', 'created_by');

        // Merchant Filtering
        if (auth()->user()->hasRole('merchant')) {
            $query->where('created_by', auth()->id());
        }

        // Type Filtering
        if ($type) {
            $query->where('type', $type);
        }

        return \Yajra\DataTables\DataTables::of($query)
            ->addColumn('action', function ($data) {
                // Determine module name for action buttons dynamically if not set globally
                $module_name = $this->module_name; 
                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('name', function($data) {
                return '<strong>' . $data->name . '</strong>';
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->diffForHumans();
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }

    public function index()
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
             $this->module_name = $type;
             $this->module_title = ucfirst($type);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = \Illuminate\Support\Str::singular($module_name);
        $module_action = 'List';

        return view(
            "tourism::backend.tourisms.index_datatable",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function create()
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
             $this->module_name = $type;
             $this->module_title = ucfirst($type);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = \Illuminate\Support\Str::singular($module_name);
        $module_action = 'Create';

        return view(
            "tourism::backend.tourisms.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function edit($id)
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
             $this->module_name = $type;
             $this->module_title = ucfirst($type);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = \Illuminate\Support\Str::singular($module_name);
        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "tourism::backend.tourisms.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    public function show($id)
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
             $this->module_name = $type;
             $this->module_title = ucfirst($type);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = \Illuminate\Support\Str::singular($module_name);
        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "tourism::backend.tourisms.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}")
        );
    }

    public function trashed()
    {
        $type = $this->getTypeFromRoute();
        if ($type) {
             $this->module_name = $type;
             $this->module_title = ucfirst($type);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = \Illuminate\Support\Str::singular($module_name);
        $module_action = 'Trash List';

        $$module_name = $module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        return view(
            "tourism::backend.tourisms.trash",
            compact('module_title', 'module_name', 'module_path', "{$module_name}", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->except(['_token', '_method', 'image']);
        $data['created_by'] = auth()->id(); // Set owner
        
        // Sanitize Price (remove 'Rp' and dots)
        if (isset($data['price'])) {
            $data['price'] = preg_replace('/[^0-9]/', '', $data['price']);
        }
        
        // Handle Image (LFM returns string path)
        if ($request->input('image')) {
            $data['image'] = $request->input('image');
        }

        // If type isn't in request, try to guess from route or fallback
        $detectedType = $this->getTypeFromRoute();
        if ($detectedType) {
            $data['type'] = $detectedType;
        }

        // Ensure type is valid
        if(!in_array($data['type'] ?? '', ['wisata'])) {
             $data['type'] = 'wisata';
        }

        $this->module_model::create($data);

        flash("New '".\Illuminate\Support\Str::singular($this->module_title)."' Added")->success()->important();

        // Redirect back to the correct index based on type and prefix
        if ($detectedType) {
             $prefix = request()->routeIs('merchant.*') ? 'merchant' : 'backend';
             return redirect()->route("{$prefix}.{$detectedType}.index");
        }

        return redirect()->route("backend.{$this->module_name}.index");
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $data = $request->except(['_token', '_method', 'image']);
        
        $module_name_singular = \Illuminate\Support\Str::singular($this->module_name);
        $record = $this->module_model::findOrFail($id);
        
        // Sanitize Price (remove 'Rp' and dots)
        if (isset($data['price'])) {
            $data['price'] = preg_replace('/[^0-9]/', '', $data['price']);
        }
        
        // Handle Image (LFM returns string path)
        if ($request->input('image')) {
            $data['image'] = $request->input('image');
        }

        $record->update($data);

        flash(\Illuminate\Support\Str::singular($this->module_title)."' Updated Successfully")->success()->important();

        // Redirect back to the correct index based on type and prefix
        $detectedType = $this->getTypeFromRoute();
        if ($detectedType) {
             $prefix = request()->routeIs('merchant.*') ? 'merchant' : 'backend';
             return redirect()->route("{$prefix}.{$detectedType}.index");
        }

        return redirect()->route("backend.{$this->module_name}.index");
    }
}
