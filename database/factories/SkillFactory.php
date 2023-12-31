<?php

namespace Database\Factories;

use App\Models\skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $color = $this
            ->faker
            ->randomElement(Skill::getAvailableBackgroundColors());

        return [
            'name' => $this->faker->unique()->word(),
            'color' => $color,
        ];
    }
}
