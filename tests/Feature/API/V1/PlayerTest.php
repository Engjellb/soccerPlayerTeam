<?php

namespace Tests\Feature\API\V1;

use App\Models\Player\Player;
use App\Models\Skill\Skill;
use App\Models\Team\Team;
use App\Models\User;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    private $team;

    protected function setUp(): void
    {
        parent::setUp();
        $adminRole = Role::findByName('admin', 'web');
        $this->team = Team::factory()->create();
        $admin = User::factory()->count(1)->for($this->team)->create()->first()->assignRole($adminRole);

        Passport::actingAs($admin, 'api');
    }

    public function test_players_are_retrieved_successfully()
    {
        $this->get_player_with_skills();

        $response = $this->getJson(route('api.players.index'));
        $response->assertStatus(200);
    }

    public function test_player_cannot_be_deleted_if_user_has_player_role()
    {
        $userRole = Role::findByName('player', 'web');
        $user = User::factory()->create();
        $user->assignRole($userRole);

        $token = Passport::actingAs($user, 'api');
        $response = $this->deleteJson(route('api.players.destroy', ['playerId' => 1]), [
           'Authorization' => "Bearer {$token}"
        ]);

        $response->assertJson(['message' => 'Unauthorized'])->assertStatus(403);
    }

    public function test_player_with_skills_is_created_successfully()
    {
        $playerData = $this->get_player_data_test();

        $response = $this->postJson(route('api.players.store'), $playerData);

        $this->assertDatabaseCount('players', 1);
        $this->assertDatabaseCount('player_skill', 2);

        $response->assertJson(['message' => 'Player has been created'])->assertCreated();
    }

    public function test_player_cannot_be_created_if_position_value_is_invalid()
    {
        $playerData = $this->get_player_with_position_invalid_value_test();

        $response = $this->postJson(route('api.players.store'), $playerData);

        $response->assertJson(['message' => 'Invalid value for position'])->assertStatus(422);
    }

    public function test_player_with_skills_is_updated_successfully()
    {
        $player = Player::factory()->count(1)->for($this->team)->create()->first();
        $playerData = $this->get_player_data_test();

        $response = $this->putJson(route('api.players.update', ['playerId' => $player->id]), $playerData);

        $this->assertDatabaseHas($player, ['name' => 'Test']);
        $this->assertDatabaseHas('player_skill', ['player_id' => 1, 'skill_id' => 1]);

        $response->assertJson(['message' => 'Player has been updated'])->assertStatus(200);
    }

    public function test_player_with_skills_is_deleted_softly()
    {
        $playerWithSkills = $this->get_player_with_skills();

        $response = $this->deleteJson(route('api.players.destroy', ['playerId' => $playerWithSkills->id]));

        $this->assertSoftDeleted($playerWithSkills);
        $this->assertSoftDeleted('player_skill');

        $response->assertJson(['message' => 'Player has been deleted'])->assertStatus(200);
    }


    public function test_player_is_not_found()
    {
        $response = $this->getJson(route('api.players.show', ['playerId' => 2]));

        $response->assertJson(['message' => 'Player not found'])->assertStatus(404);
    }

    public function test_player_is_retrieved_successfully()
    {
        $playerWithSkills = $this->get_player_with_skills();
        $response = $this->getJson(route('api.players.show', ['playerId' => $playerWithSkills->id]));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_retrieve_players_of_another_team()
    {
        $teamOne = $this->team; // id: 1
        $teamTwo = Team::factory()->create(); // id: 2
        Player::factory()->count(5)->for($teamOne)->create();
        Player::factory()->count(5)->for($teamTwo)->create();

        $response = $this->getJson(route('api.players.index'));
        $responseData = $response->collect('data');

        $this->assertNotTrue($responseData->contains('team.id', 2));
    }

    public function test_super_admin_can_retrieve_players_of_all_teams()
    {
        $superAdminRole = Role::findByName('super-admin', 'web');
        $superAdmin = User::factory()->create()->assignRole($superAdminRole);
        Passport::actingAs($superAdmin, 'api');

        $teamOne = $this->team; // id: 1
        $teamTwo = Team::factory()->create(); // id: 2
        Player::factory()->count(5)->for($teamOne)->create();
        Player::factory()->count(5)->for($teamTwo)->create();

        $response = $this->getJson(route('api.players.index'));
        $responseData = $response->collect('data');

        $this->assertTrue($responseData->contains('team.id', 1));
        $this->assertTrue($responseData->contains('team.id', 2));
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
            ],
            "teamId" => 1
        ];
    }

    private function get_player_with_skills()
    {
        $skillsIds = Skill::all()->random(2)->pluck('id');

        $player = Player::factory()->count(1)->for($this->team)->create()->first();
        $player->skills()->attach($skillsIds);

        return $player;
    }
}
