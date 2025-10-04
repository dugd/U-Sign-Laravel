<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Gesture;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gesture>
 */
class GestureFactory extends Factory
{
    protected $model = Gesture::class;
    protected static ?string $languageCode;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => Str::slug($this->faker->unique()->word() . '-' . $this->faker->unique()->numberBetween(1, 9999)),
            'created_by' => User::factory(),
            'canonical_language_code' => static::$languageCode ??= 'en',
        ];
    }
}
