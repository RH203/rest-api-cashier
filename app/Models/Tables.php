<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tables extends Model
{
  public function reservations(): HasMany
  {
    return $this->hasMany(Reservations::class);
  }
}
