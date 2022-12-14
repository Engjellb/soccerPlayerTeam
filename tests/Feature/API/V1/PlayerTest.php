<?php

namespace Tests\Feature\API\V1;

use App\Models\Player\Player;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public function test_players_are_retrieved_successfully()
    {
        Player::factory()->count(2)->create();

        $response = $this->getJson(route('players.index'));
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'position',
                    'playerSkills' => [
                        '*' => [
                            'id',
                            'skill',
                            'value',
                            'playerId'
                        ]
                    ]
                ]
            ]
        ])->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::find(1);
        Passport::actingAs($user, 'api');
    }
}
