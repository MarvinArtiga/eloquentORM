<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $items = [
            ['name' => 'Bruschetta', 'description' => 'Grilled bread with tomatoes and basil', 'price' => 7.50, 'category' => 'Entradas', 'available' => true],
            ['name' => 'Ensalada César', 'description' => 'Romaine, croutons, parmesan', 'price' => 9.00, 'category' => 'Entradas', 'available' => true],
            ['name' => 'Spaghetti Bolognese', 'description' => 'Classic beef ragu with spaghetti', 'price' => 14.00, 'category' => 'Pastas', 'available' => true],
            ['name' => 'Pollo a la Parrilla', 'description' => 'Grilled chicken with herbs', 'price' => 16.50, 'category' => 'Platos principales', 'available' => true],
            ['name' => 'Tiramisú', 'description' => 'Coffee-flavoured Italian dessert', 'price' => 6.50, 'category' => 'Postres', 'available' => true],
            ['name' => 'Copa de Vino', 'description' => 'Glass of house red or white wine', 'price' => 5.00, 'category' => 'Bebidas', 'available' => true],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
