<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    $faker = Faker::create();
    $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));


    $categories = Categories::all();

    for ($i = 0; $i < 10; $i++) {

      Products::create([
        'name' => $faker->foodName(),
        'category_id' => $categories->where('name', 'Food')->first()->id,
        'price' => $faker->randomFloat(2, 5000, 30000),
        'stock' => $faker->numberBetween(10, 100),
      ]);


      Products::create([
        'name' => $faker->beverageName(),
        'category_id' => $categories->where('name', 'Drink')->first()->id,
        'price' => $faker->randomFloat(2, 2000, 15000),
        'stock' => $faker->numberBetween(10, 100),
      ]);


      Products::create([
        'name' => $faker->dairyName(),
        'category_id' => $categories->where('name', 'Desert')->first()->id,
        'price' => $faker->randomFloat(2, 3000, 15000),
        'stock' => $faker->numberBetween(10, 100),
      ]);
    }
  }
}
