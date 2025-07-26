<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommodityLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            'Gudang Desain Komunikasi Visual',
            'Gudang Manajemen Perkantoran dan Layanan Bisnis',
            'Gudang Perhotelan',
            'Gudang Tata Boga',
            'Gudang Tata Busana'
        ];
    }
}
