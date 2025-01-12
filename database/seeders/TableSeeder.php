<?php

namespace Database\Seeders;

use App\Models\Tables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    for ($i = 1; $i <= 50; $i++) {
      Tables::create([
        'table_number' => $i,
      ]);
    }
  }
}
