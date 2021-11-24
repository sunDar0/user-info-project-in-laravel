<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'order_id' => $this->faker->unique()->isbn10(),
            'user_id' => User::latest('created_at')->first()->id,
            'product_name' => $this->faker->text(50).$this->faker->emoji(),
            'order_date' => $this->faker->dateTimeBetween('-1 months', 'now'),
            'payment_date' => $this->faker->dateTimeBetween('-1 months', 'now')
        ];
    }
}
