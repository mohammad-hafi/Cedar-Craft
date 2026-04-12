<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
     protected $fillable = ['name', 'description','material_id', 'price', 'stock', 'dimensions'];

     public function images():HasMany
     {
        return $this->hasMany(ProductImages::class);
     }
     public function orderitems():HasMany
     {
        return $this->hasMany(OrderItem::class);
     }
        public function material()
        {
            return $this->hasMany(Material::class);
        }
}
