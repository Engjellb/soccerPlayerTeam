<?php

namespace Tests\Feature\API\V1;

use App\Models\Player\Player;
use App\Models\Skill\Skill;
use App\Models\User;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::find(1);
        Passport::actingAs($admin, 'api');
    }

    public function test_players_are_retrieved_successfully()
    {
        $this->get_player_with_skills();

        $response = $this->getJson(route('players.index'));
        $response->assertStatus(200);
    }

    public function test_player_cannot_be_deleted_if_user_has_player_role()
    {
        $userRole = Role::find(2);
        $user = User::factory()->create();
        $user->assignRole($userRole);

        $token = Passport::actingAs($user, 'api');
        $response = $this->deleteJson(route('players.destroy', ['playerId' => 1]), [
           'Authorization' => "Bearer {$token}"
        ]);

        $response->assertJson(['message' => 'Unauthorized'])->assertStatus(403);
    }

    public function test_player_with_skills_is_created_successfully()
    {
        $playerData = $this->get_player_data_test();

        $response = $this->postJson(route('players.store'), $playerData);

        $this->assertDatabaseCount('players', 1);
        $this->assertDatabaseCount('player_skill', 2);

        $response->assertJson(['message' => 'CreatedPlayer has been created'])->assertCreated();
    }

    public function test_player_cannot_be_created_if_position_value_is_invalid()
    {
        $playerData = $this->get_player_with_position_invalid_value_test();

        $response = $this->postJson(route('players.store'), $playerData);

        $response->assertJson(['message' => 'Invalid value for position'])->assertStatus(422);
    }

    public function test_player_with_skills_is_updated_successfully()
    {
        $player = Player::factory()->create();
        $playerData = $this->get_player_data_test();

        $response = $this->putJson(route('players.update', ['playerId' => $player->id]), $playerData);

        $this->assertDatabaseHas($player, ['name' => 'Test']);
        $this->assertDatabaseHas('player_skill', ['player_id' => 1, 'skill_id' => 1]);

        $response->assertJson(['message' => 'CreatedPlayer has been updated'])->assertStatus(200);
    }

    public function test_player_with_skills_is_deleted_softly()
    {
        $playerWithSkills = $this->get_player_with_skills();

        $response = $this->deleteJson(route('players.destroy', ['playerId' => $playerWithSkills->id]));

        $this->assertSoftDeleted($playerWithSkills);
        $this->assertSoftDeleted('player_skill');

        $response->assertJson(['message' => 'CreatedPlayer has been deleted'])->assertStatus(200);
    }


    public function test_player_is_not_found()
    {
        $response = $this->getJson(route('players.show', ['playerId' => 2]));

        $response->assertJson(['message' => 'CreatedPlayer not found'])->assertStatus(404);
    }

    public function test_player_is_retrieved_successfully()
    {
        $playerWithSkills = $this->get_player_with_skills();
        $response = $this->getJson(route('players.show', ['playerId' => $playerWithSkills->id]));

        $response->assertStatus(200);
    }

    private function get_player_with_position_invalid_value_test()
    {
        return [
            'name' => 'Test',
            'position' => 'goalkeeper',
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
    }

    private function get_player_data_test()
    {
        return [
            'name' => 'Test',
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
    }

    private function get_player_with_skills()
    {
        $skillsIds = Skill::all()->random(2)->pluck('id');

        $player = Player::factory()->create();
        $player->skills()->attach($skillsIds);

        return $player;
    }
}
