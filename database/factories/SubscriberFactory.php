<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $websiteIds = Website::all()->pluck('id');

        return [
            'website_id'  => $this->faker->randomElement($websiteIds),
            'email'       => $this->faker->email(),
        ];
    }
}
