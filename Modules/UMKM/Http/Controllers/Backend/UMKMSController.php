<?php

namespace Modules\UMKM\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class UMKMSController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'UMKMS';

        // module name
        $this->module_name = 'umkms';

        // directory path of the module
        $this->module_path = 'umkm::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\UMKM\Models\UMKM";
    }

}
