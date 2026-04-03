<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Jasa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jasa>
 */
class JasaFactory extends Factory
{
    protected $model = Jasa::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'nama_jasa' => $this->faker->words(3, true),
            'biaya' => $this->faker->randomFloat(2, 100000, 1000000),
            'qty' => $this->faker->numberBetween(1, 5),
        ];
    }
}
