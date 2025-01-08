<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservations extends Model
{
  public function users()
  {
    return $this->belongsTo(User::class);
  }

  public function tables()
  {
    return $this->belongsTo(Tables::class);
  }
}
