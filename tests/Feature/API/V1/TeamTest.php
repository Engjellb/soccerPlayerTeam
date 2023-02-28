<?php

namespace Tests\Feature\API\V1;

use App\Models\Team\Team;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class TeamTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $superAdmin = User::find(1);
        Passport::actingAs($superAdmin, 'api');
    }

    public function test_teams_are_retrieved_successfully()
    {
        Team::factory()->count(2)->create();

        $response = $this->getJson(route('api.teams.index'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ])->assertStatus(200);
    }

    public function test_team_is_retrieved_successfully()
    {
        $team = Team::factory()->create();

        $response = $this->getJson(route('api.teams.show', ['teamId' => $team->id]));

        $response->assertJson([
            'data' => [
                'id' => $team->id,
                'name' => $team->name
            ]
        ])->assertStatus(200);
    }

    public function test_team_has_been_created_successfully()
    {
        $teamData = [
            'name' => 'Team test'
        ];

        $response = $this->postJson(route('api.teams.store'), $teamData);

        $response->assertJson(['data' => [
            'id' => 1,
            'name' => $teamData['name']
        ]])->assertStatus(201);
    }

    public function test_team_is_updated_successfully()
    {
        $team = Team::factory()->create();

        $teamData = [
            'name' => 'Team test updated'
        ];

        $response = $this->putJson(route('api.teams.update', ['teamId' => $team->id]), $teamData);

        $this->assertDatabaseHas('teams', [
            'name' => $teamData['name']
        ]);
        $response->assertJson(['data' => [
            'id' => 1,
            'name' => $teamData['name']
        ]])->assertStatus(200);
    }

    public function test_team_is_deleted_softly()
    {
        $team = Team::factory()->create();

        $response = $this->deleteJson(route('api.teams.destroy', ['teamId' => $team->id]));

        $this->assertSoftDeleted($team);
        $response->assertJson(['message' => 'Team has been deleted'])->assertStatus(200);
    }
}
