<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['buyer', 'admin'] as $role) {
            User::firstOrCreate(['email' => "$role@ajs.test"], ['name' => 'Demo '.ucfirst($role), 'password' => Hash::make('password'), 'role' => $role]);
        }
        $products = [
            ['Cakalang / Skipjack Tuna', 'cakalang-skipjack-tuna', 'cakalang.jpg', 'A', 'Muara Baru', 850, 100],
            ['Deho', 'deho', 'deho.jpg', 'A', 'Muara Baru', 1200, 100],
            ['Tuna Fillet', 'tuna-fillet', 'tuna.jpg', 'Premium', 'Partner Supply', 350, 50],
            ['Kerapu / Grouper', 'kerapu-grouper', 'kerapu.jpg', 'A', 'Muara Baru', 180, 25],
        ];
        foreach ($products as [$name,$slug,$image,$grade,$origin,$quantity,$moq]) {
            Product::firstOrCreate(['slug' => $slug], [
                'name' => $name, 'description' => "$name supplied frozen, subject to availability and confirmation of your supply requirements.",
                'image' => "assets/ajs/$image", 'grade' => $grade, 'form' => 'Frozen', 'origin' => $origin,
                'available_quantity' => $quantity, 'moq' => $moq, 'availability' => 'available',
            ]);
        }
    }
}
