<?php

namespace Database\Factories\Player;

use App\Enums\Player\PlayerPositionEnum;
use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement([PlayerPositionEnum::DEFENDER, PlayerPositionEnum::MIDFIELDER,
                PlayerPositionEnum::FORWARD]),
            'team_id' => Team::factory()->create()->id
        ];
    }
}
