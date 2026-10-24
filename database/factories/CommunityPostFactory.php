<?php

namespace Database\Factories;

use App\Enums\CommunityPostType;
use App\Enums\DistressStatus;
use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommunityPost>
 */
class CommunityPostFactory extends Factory
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
            'type' => CommunityPostType::Hazard,
            'message' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'photo_path' => null,
            'distress_status' => null,
        ];
    }

    public function distress(): static
    {
        return $this->state(fn () => [
            'type' => CommunityPostType::Distress,
            'distress_status' => DistressStatus::Open,
        ]);
    }
}
