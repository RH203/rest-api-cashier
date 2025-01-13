<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{

  protected $fillable = ['quantity', 'product_id', 'order_id'];
  public function orders()
  {
    return $this->belongsTo(Orders::class);
  }
  public function products()
  {
    return $this->belongsTo(Products::class);
  }
}
