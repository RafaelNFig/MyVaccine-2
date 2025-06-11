<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Post;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'post_id' => Post::factory(),
            'vaccine_id' => Vaccine::factory(),
            'quantity' => $this->faker->numberBetween(0, 500),
            'batch' => strtoupper($this->faker->bothify('Lote-###')),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}