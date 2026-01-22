<?php

namespace Modules\Culinary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\User;

class CulinaryOrder extends BaseModel
{
    use HasFactory;

    protected $table = 'culinary_orders';

    protected $fillable = [
        'user_id',
        'culinary_id',
        'invoice_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'delivery_latitude',
        'delivery_longitude',
        'courier_name',
        'courier_service',
        'courier_description',
        'biteship_order_id',
        'biteship_tracking_id',
        'total_price',
        'delivery_fee',
        'grand_total',
        'snap_token',
        'payment_status',
        'order_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function culinary()
    {
        return $this->belongsTo(Culinary::class);
    }

    public function items()
    {
        return $this->hasMany(CulinaryOrderItem::class);
    }
}
