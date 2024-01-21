<?php

namespace Database\Factories;

use App\Models\CoffeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CoffeeType>
 */
class CoffeeTypeFactory extends Factory
{
    protected $model = CoffeeType::class;

    public function definition()
    {
        return [
            'coffee_name' => $this->faker->word,
            'profit_margin' => $this->faker->numberBetween($min = 0.01, $max = 0.99),
        ];
    }
}
