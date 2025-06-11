<?php

namespace Database\Factories;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineFactory extends Factory
{
    protected $model = Vaccine::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word() . 'Vacina',
            'min_age' => $this->faker->numberBetween(0, 10),
            'max_age' => $this->faker->optional()->numberBetween(11, 100),
            'contraindications' => $this->faker->optional()->sentence(),
            
        ];
    }
}