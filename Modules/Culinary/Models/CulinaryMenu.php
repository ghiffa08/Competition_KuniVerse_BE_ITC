<?php

namespace Modules\Culinary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel; // Assuming BaseModel exists, as seen in Culinary.php/Menu.php (Modules\Menu\Models\Menu extends BaseModel)

class CulinaryMenu extends BaseModel
{
    use HasFactory;

    protected $table = 'culinary_menus';

    protected $fillable = [
        'culinary_id',
        'name',
        'price',
        'category', // makanan, minuman, cemilan
        'image',
        'description',
        'is_available',
        'sort_order',
        'created_by',
        'updated_by'
    ];

    public function culinary()
    {
        return $this->belongsTo(Culinary::class);
    }
}
