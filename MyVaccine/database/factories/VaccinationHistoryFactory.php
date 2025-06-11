<?php

namespace Database\Factories;

use App\Models\VaccinationHistory;
use App\Models\User;
use App\Models\Post;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccinationHistoryFactory extends Factory
{
    protected $model = VaccinationHistory::class;

    public function definition()
    {
        return [
            'user_cpf' => User::factory()->create()->cpf,
            'vaccine_id' => Vaccine::factory(),
            'post_id' => Post::factory(),
            'batch' => strtoupper($this->faker->bothify('Lote-###')),
        ];
    }
}