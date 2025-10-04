<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GestureTranslation;
use App\Models\Gesture;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GestureTranslation>
 */
class GestureTranslationFactory extends Factory
{
    protected $model = GestureTranslation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gesture_id' => Gesture::factory(),
            'language_code' => 'en',
            'title' => ucfirst($this->faker->word()),
            'description' => $this->faker->paragraph(3),
            'video_path' => 'videos/sample-' . $this->faker->numberBetween(1, 5) . '.mp4',
        ];
    }
}
