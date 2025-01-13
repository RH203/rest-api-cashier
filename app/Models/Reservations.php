<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservations extends Model
{

  protected $fillable = ['contact_person', 'number_of_people', 'reservation_time', 'user_id', 'table_id'];

  public function users()
  {
    return $this->belongsTo(User::class);
  }

  public function tables()
  {
    return $this->belongsTo(Tables::class);
  }
}
