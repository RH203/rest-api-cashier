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
    Schema::create('orders_details', function (Blueprint $table) {
      $table->id()->autoIncrement()->primary();
      $table->integer('quantity');
      $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
      $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders_detail');
  }
};

