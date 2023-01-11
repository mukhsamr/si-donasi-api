<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InfaqFactory extends Factory
{
    public function definition()
    {
        return [
            'judul' => 'Infaq ' . fake()->name(),
            'deskripsi' => fake()->paragraph(),
            'bank' => 'BSI',
            'rekening' => '7000030091',
            'target' => 1000000,
            'gambar' => null,
        ];
    }
}
