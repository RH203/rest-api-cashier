<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
  public function run(): void
  {
    $categories = [
      ['name' => 'Food'],
      ['name' => 'Drink'],
      ['name' => 'Desert'],
    ];

    foreach ($categories as $category) {
      Categories::create($category);
    }
  }
}
