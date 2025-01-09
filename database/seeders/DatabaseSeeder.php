<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    $this->call(SuperAdminCashierSeeder::class);
    $this->call(CategoriesSeeder::class);
    $this->call(ProductSeeder::class);

  }
}
