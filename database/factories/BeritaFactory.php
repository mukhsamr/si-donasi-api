<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeritaFactory extends Factory
{
    public function definition()
    {
        return [
            'judul' => 'Berita ' . fake()->name(),
            'deskripsi' => fake()->paragraph(6),
            'gambar' => null,
        ];
    }
}
