<?php

namespace Modules\Tourism\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'tourism_reviews';
    protected $fillable = ['tourism_id', 'user_id', 'rating', 'review'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourism()
    {
        return $this->belongsTo(Tourism::class);
    }
}
