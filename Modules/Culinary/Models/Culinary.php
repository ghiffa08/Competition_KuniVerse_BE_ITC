<?php

namespace Modules\Culinary\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Culinary extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'culinaries';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Culinary\database\factories\CulinaryFactory::new();
    }

    public function menus()
    {
        return $this->hasMany(CulinaryMenu::class);
    }
}
