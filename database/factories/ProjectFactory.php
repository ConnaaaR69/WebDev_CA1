<?php

namespace Database\Factories;

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

        return [
            'title' => $this->faker->sentence(),
            'text' => $this->faker->paragraph(5),
            'tags' => 'tag1,tag2,tag3',
            'image' => $this->faker->image(public_path('img'), 640, 480, null, false)
        ];
    }
}
