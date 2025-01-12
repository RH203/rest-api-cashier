<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountCashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Cashier 1
      User::create([
        'name'=> 'cashier',
        'password' => Hash::make('password')
      ]);

      // Cashier 2
      User::create([
        'name'=> 'cashier2',
        'password' => Hash::make('password')
      ]);
    }
}
