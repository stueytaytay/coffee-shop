<?php

namespace Database\Factories;

use App\Models\ShippingPartner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingPartner>
 */
class ShippingPartnerFactory extends Factory
{
    protected $model = ShippingPartner::class;

    public function definition()
    {
        return [
            'partner_name' => $this->faker->word,
            'shipping_cost' => $this->faker->numberBetween($min = 5, $max = 10),
        ];
    }
}
