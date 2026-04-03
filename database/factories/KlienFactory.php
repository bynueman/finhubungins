<?php

namespace Database\Factories;

use App\Models\Klien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Klien>
 */
class KlienFactory extends Factory
{
    protected $model = Klien::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nama_instansi' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'no_telp' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
