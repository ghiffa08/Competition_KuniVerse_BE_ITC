<?php

namespace Modules\UMKM\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UMKM extends BaseModel
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
        return \Modules\UMKM\database\factories\UMKMFactory::new();
    }
}
