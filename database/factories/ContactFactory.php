<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'birthday' => $this->faker->date,
            'telephone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'credit_card' => $this->faker->creditCardNumber,
            'email' => $this->faker->email,
        ];
    }
}
