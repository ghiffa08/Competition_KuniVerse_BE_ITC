<?php

namespace Modules\Tourism\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tourism extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tourisms';

    protected $fillable = [
        'name',
        'slug',
        'intro',
        'content',
        'price',
        'rating',
        'image',
        'images',
        'address',
        'open_hours',
        'facilities',
        'note',
        'status',
        'type',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'images' => 'array',
        'latitude' => 'double',
        'longitude' => 'double',
        'rating' => 'double',
        'price' => 'double',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tourism\database\factories\TourismFactory::new();
    }
}
