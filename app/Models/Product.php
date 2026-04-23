<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
     protected $fillable = ['name', 'description','material_id','category_id', 'price', 'stock', 'dimentions'];

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
            return $this->belongsTo(Material::class);
        }
         public function category()
         {
               return $this->belongsTo(Category::class);
         }
}
