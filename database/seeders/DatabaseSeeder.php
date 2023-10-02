<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Sample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $this->call([OrderStatusSeeder::class]);
        /** @var Sample $sample */
        $sample = Sample::factory(20)->create()->first();

//        /** @var Order $order */
//        $order = $sample->orders()->create(['order_status_id' => 1]);
//        $order->addQuantities([38 => 10, 41 => 20, 43 => 15, 45 => 6]);
        // \App\Models\User::factory(10)->create();

//         \App\Models\User::factory()->create([
//             'name' => 'Admin',
//             'email' => 'admin@admin.com',
//         ]);
    }
}
