<?php

namespace Database\Factories;

use App\Models\project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $colorName = $this
            ->faker
            ->randomElement(project::getAvailableTextColors());

        $iconName = $this
            ->faker
            ->randomElement(project::getAvailableIcons());

        return [
            'title' => $this->faker->unique()->word(2, true),
            'description' => $this->faker->sentence(),
            'color' => $colorName,
            'icon_name' => $iconName,
        ];
    }
}
