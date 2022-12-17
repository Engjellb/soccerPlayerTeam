<?php

namespace Tests\Feature\API\V1;

use App\Models\Player\Player;
use App\Models\Skill\Skill;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public function test_players_are_retrieved_successfully()
    {
        $this->get_players_with_skills();

        $response = $this->getJson(route('players.index'));
        $response->assertStatus(200);
    }

    public function test_player_is_created_successfully()
    {
        $playerData = [
            'name' => 'position',
            'position' => 'midfielder',
            'playerSkills' => [
                [
                    'skill' => 'defense',
                    'value' => '50'
                ],
                [
                    'skill' => 'stamina'
                ],
            ]
        ];
        $response = $this->postJson(route('players.store'), $playerData);
        $response->assertJson(['message' => 'Player has been created'])->assertCreated();
    }


    public function test_player_is_not_found()
    {
        $response = $this->getJson(route('players.show', ['playerId' => 2]));

        $response->assertJson(['message' => 'Player not found'])->assertStatus(404);
    }

    public function test_player_is_retrieved_successfully()
    {
        Player::factory()->create();
        $response = $this->getJson(route('players.show', ['playerId' => 1]));

        $response->assertStatus(200);
    }

    private function get_players_with_skills()
    {
        $skillsIds = Skill::all()->random(2)->pluck('id');
        $players = Player::factory()->count(2)->create();

        return $players->map(function ($player) use ($skillsIds) {
            return $player->skills()->attach($skillsIds);
        });
    }

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::find(1);
        Passport::actingAs($user, 'api');
    }
}
