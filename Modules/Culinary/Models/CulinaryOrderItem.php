<?php

namespace Modules\Culinary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CulinaryOrderItem extends Model
{
    use HasFactory;

    protected $table = 'culinary_order_items';

    protected $fillable = [
        'culinary_order_id',
        'culinary_menu_id',
        'name',
        'price',
        'qty',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(CulinaryOrder::class);
    }

    public function menu()
    {
        return $this->belongsTo(CulinaryMenu::class);
    }
}
