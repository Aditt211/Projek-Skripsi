<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commodity_locations')->insert([
            ['name' => 'Warehouse 1', 'description' => 'Main warehouse for storage'],
            ['name' => 'Warehouse 2', 'description' => 'Secondary warehouse for overflow'],
            ['name' => 'Showroom', 'description' => 'Display area for commodities'],
        ]);
    }
}