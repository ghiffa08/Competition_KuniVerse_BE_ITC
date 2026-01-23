<?php

namespace Modules\UMKM\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UMKMOrder extends BaseModel
{
    use HasFactory;

    protected $table = 'umkm_orders';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(UMKMOrderItem::class, 'order_id');
    }

    public function umkm()
    {
        return $this->belongsTo(UMKM::class, 'umkm_id');
    }
}
