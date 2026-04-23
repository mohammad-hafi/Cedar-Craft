<?php

namespace App\Models;

use App\Models\DesignImages;
use App\Models\Material;
use App\Models\User;
use App\RequestStatus;
use App\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Design extends Model
{
    protected $fillable = ['user_id','product_name', 'description','material_id','category_id', 'estimated_price', 'status', 'dimentions'];
    protected $casts=[
        'status'=>RequestStatus::class,
    ];
    protected $attributes = [
        'status'=>RequestStatus::PENDING,
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
        public function category()
         {
               return $this->belongsTo(Category::class);
         }
}
