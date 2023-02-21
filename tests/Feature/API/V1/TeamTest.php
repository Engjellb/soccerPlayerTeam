<?php

namespace Tests\Feature\API\V1;

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

    public function test_team_has_been_created_successfully()
    {
        $teamData = [
            'name' => 'Team test'
        ];

        $response = $this->postJson(route('api.teams.store'), $teamData);

        $response->assertJson(['data' => [
            'id' => 1,
            'name' => 'Team test'
        ]])->assertStatus(201);
    }
}
