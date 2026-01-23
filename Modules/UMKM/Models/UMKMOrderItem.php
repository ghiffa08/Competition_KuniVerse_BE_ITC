<?php

namespace Modules\UMKM\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UMKMOrderItem extends BaseModel
{
    use HasFactory;

    protected $table = 'umkm_order_items';

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(UMKMOrder::class, 'order_id');
    }
}
