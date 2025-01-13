<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{

  protected $fillable = ['user_id', 'order_number', 'total_price'];
  public function users()
  {
    return $this->belongsTo(User::class);
  }

  public function payments(): HasOne
  {
    return $this->HasOne(Payments::class);
  }

  public function orders_detail():HasMany
  {
    return $this->hasMany(OrdersDetail::class);
  }
}
