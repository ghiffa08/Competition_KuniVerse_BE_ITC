<?php

namespace Modules\Culinary\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class CulinariesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Culinaries';

        // module name
        $this->module_name = 'culinaries';

        // directory path of the module
        $this->module_path = 'culinary::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Culinary\Models\Culinary";
    }

}
