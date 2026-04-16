<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
   protected $fillable = ['id','type'];
   public function design()
   {
    return $this->hasMany(Design::class);
   }
   public function product()
   {
    return $this->hasMany(Product::class);
   }
}
