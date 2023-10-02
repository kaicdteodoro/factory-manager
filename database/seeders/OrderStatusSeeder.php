<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (OrderStatus::default as $id => $name) {
            OrderStatus::query()->updateOrCreate(compact('id'), compact('name'));
        }
    }
}
