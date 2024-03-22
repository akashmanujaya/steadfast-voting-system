<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            ['name' => 'WhatsApp', 'icon' => 'fa fa-whatsapp', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Facebook', 'icon' => 'fa fa-facebook', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Instagram', 'icon' => 'fa fa-instagram', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Twitter', 'icon' => 'fa fa-twitter', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
