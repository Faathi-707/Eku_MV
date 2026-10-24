<?php

namespace Database\Factories;

use App\Enums\DisruptionCategory;
use App\Enums\DisruptionReportStatus;
use App\Models\DisruptionReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisruptionReport>
 */
class DisruptionReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category' => $this->faker->randomElement(DisruptionCategory::cases()),
            'cause' => $this->faker->paragraph(),
            'clearance_period' => $this->faker->randomElement(['24h', '48h', 'week', 'extended']),
            'clear_by' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'alternative_routes' => $this->faker->sentence(),
            'other_info' => null,
            'affected_area' => $this->faker->city(),
            'geojson' => null,
            'status' => DisruptionReportStatus::Draft,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => DisruptionReportStatus::Published,
            'published_at' => now(),
        ]);
    }
}
