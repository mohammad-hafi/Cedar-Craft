<?php

namespace App\Models;

use App\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // protected $fillable = ['user_id', 'status'];
    protected $casts=[
        'status'=>Status::class,
    ];
    protected $attributes = [
        'status'=>Status::PENDING,
    ];

    public function items():HasMany
     {
        return $this->hasMany(OrderItem::class);
     }
     public function user()
     {
        return $this->belongsTo(User::class);
     }
}
