<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{

  use HasFactory;

  protected $fillable = ['name', 'price', 'category_id'];
  public function orders_detail(): HasMany
  {
    return $this->hasMany(OrdersDetail::class);
  }

  public function category()
  {
    return $this->belongsTo(Categories::class);
  }
}
