<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            // 'banner' => $this->faker->imageUrl(1200, 400, 'nature', true, 'banner'),
            // 'avatar' => $this->faker->imageUrl(400, 400, 'people', true, 'avatar'),
            'location' => $this->faker->city(),
            'bio' => $this->faker->paragraph(),
            'occupation' => $this->faker->jobTitle(),
            'education' => $this->faker->sentence(),
        ];
    }
}
