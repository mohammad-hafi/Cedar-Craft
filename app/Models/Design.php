<?php

namespace App\Models;

use App\Models\DesignImages;
use App\Models\Material;
use App\Models\User;
use App\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Design extends Model
{
    protected $fillable = ['user_id','product_name', 'description','material_id', 'estimated_price', 'status', 'dimentions'];
    protected $casts=[
        'status'=>Status::class,
    ];
    protected $attributes = [
        'status'=>Status::PENDING,
    ];
     public function images():HasMany
     {
        return $this->hasMany(DesignImages::class);
     }
     public function user()
     {
        return $this->belongsTo(User::class);
     }
      public function material()
        {
            return $this->belongsTo(Material::class);
        }
}
