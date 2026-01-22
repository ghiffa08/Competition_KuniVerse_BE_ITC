<?php

namespace Modules\Umkm\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umkm extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'umkms';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Umkm\database\factories\UmkmFactory::new();
    }
}
