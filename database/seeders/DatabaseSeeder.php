<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Gesture;
use App\Models\GestureTranslation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    static string $locale = 'en';

    public function run(): void
    {
        $users = User::factory(5)->create();

        $users->each(function ($user) {
            $gestures = Gesture::factory(5)->create([
                'created_by' => $user->id,
                'canonical_language_code' => static::$locale,
            ]);

            $gestures->each(function ($gesture) use ($user) {
                GestureTranslation::factory(1)->create([
                    'gesture_id' => $gesture->id,
                    'language_code' => static::$locale,
                    'video_path' => 'videos/sample.mp4',
                ]);

                Comment::factory(2)->create([
                    'gesture_id' => $gesture->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
