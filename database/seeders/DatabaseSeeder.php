<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $this->call(AccountCashierSeeder::class);
    $this->call(AdminCashierSeeder::class);
    $this->call(CategoriesSeeder::class);
    $this->call(ProductSeeder::class);
    $this->call(TableSeeder::class);

  }
}
