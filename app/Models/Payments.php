<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{

  protected $fillable = ['amount_paid', 'change_due', 'payment_method', 'order_id'];
    public function orders()
    {
      return $this->belongsTo(Orders::class);
    }
}
