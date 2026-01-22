<?php

namespace Modules\Booking\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'tourism_id',
        'booking_date',
        'quantity',
        'total_price',
        'status',
        'snap_token',
        'payment_url',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tourism()
    {
        return $this->belongsTo(\Modules\Tourism\Models\Tourism::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Booking\database\factories\BookingFactory::new();
    }
}
