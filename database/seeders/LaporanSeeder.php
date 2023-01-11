<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run()
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];

        $data = [];

        foreach ($bulan as $item) {
            $data[] = [
                'bulan' => $item,
                'pdf' => 'sample.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        Laporan::insert($data);
    }
}
