<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'cpf' => $this->faker->unique()->numerify('###########'),
            'role' => 'usuario',
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('senha123'),
            'dob' => $this->faker->date('Y-m-d', '2010-01-01'),
            'address' => $this->faker->address,
            'telephone' => $this->faker->numerify('819########'),
        ];
    }
}
