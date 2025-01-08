<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('reservations', function (Blueprint $table) {
      $table->id()->autoIncrement()->primary();
      $table->string('contact_person');
      $table->integer('number_of_people');
      $table->dateTime('reservation_time');
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropifExists('reservations');
  }
};
