<?php

namespace Modules\Booking\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class BookingsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Bookings';

        // module name
        $this->module_name = 'bookings';

        // directory path of the module
        $this->module_path = 'booking::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Booking\Models\Booking";
    }

}
