<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Berita;
use App\Models\Infaq;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
        ]);

        // Infaq::factory(5)->create();
        // Berita::factory(5)->create();

        // $this->call([
        //     LaporanSeeder::class
        // ]);
    }
}
