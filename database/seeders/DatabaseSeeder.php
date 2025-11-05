<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed suppliers and products for inventory demo
        \App\Models\Supplier::factory()->count(5)->create()->each(function($supplier){
            \App\Models\Product::factory()->count(5)->create(['supplier_id' => $supplier->id]);
        });
    }
}
