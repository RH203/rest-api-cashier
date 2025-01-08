<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
  public function orders_detail(): HasMany
  {
    return $this->hasMany(OrdersDetail::class);
  }

  public function categories()
  {
    return $this->belongsTo(Categories::class);
  }
}
