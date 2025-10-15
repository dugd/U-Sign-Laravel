<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plans = ['vip', 'pro'];
        $startsAt = $this->faker->dateTimeBetween('-1 month', 'now');
        $endsAt = $this->faker->optional(0.7)->dateTimeBetween('now', '+2 months');
        $canceledAt = $this->faker->optional(0.2)->dateTimeBetween($startsAt, $endsAt ?: '+2 months');
        return [
            'user_id' => fn() => User::factory(),
            'plan' => $this->faker->randomElement($plans),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'canceled_at' => $canceledAt,
        ];
    }
}
