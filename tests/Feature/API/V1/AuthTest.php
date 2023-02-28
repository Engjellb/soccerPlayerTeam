<?php

namespace Tests\Feature\API\V1;

use App\Models\Team\Team;
use App\Models\User;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_is_logged_in_successfully()
    {
        $userCredentialsDataTest = [
            'email' => 'superAdmin@test.com',
            'password' => 'superAdminTest'
        ];

        $response = $this->postJson(route('api.auth.login'), $userCredentialsDataTest);

        $this->assertDatabaseCount('oauth_access_tokens', 1);
        $response->assertJson(['message' => 'User is logged in successfully'])->assertStatus(200);
    }

    public function test_user_has_incorrect_credentials()
    {
        $userInvalidCredentialsTest = [
            'email' => 'adminn@test.com',
            'password' => 'adminTest'
        ];

        $response = $this->postJson(route('api.auth.login'), $userInvalidCredentialsTest);

        $this->assertDatabaseEmpty('oauth_access_tokens');
        $response->assertJson(['message' => 'Your email or password is incorrect'])->assertStatus(401);
    }

    public function test_user_is_registered_successfully()
    {
        $superAdmin = User::find(1);
        Passport::actingAs($superAdmin, 'api');

        $team = Team::factory()->create();

        $userData = [
            "name" => 'Test',
            "email" => 'test@test.com',
            "userType" => 'admin',
            "password" => 'userTest',
            "passwordConfirmation" => 'userTest',
            "teamId" => $team->id
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('oauth_access_tokens', 1);
        $this->assertDatabaseCount('model_has_roles', 2);

        $response->assertJson(['message' => 'User is registered successfully'])->assertStatus(201);
    }

    public function test_user_admin_cannot_create_an_admin()
    {
        $admin = User::factory()->create();
        $adminRole = Role::findByName('admin', 'web');
        $admin->assignRole($adminRole);
        Passport::actingAs($admin, 'api');

        $team = Team::factory()->create();

        $userData = [
            "name" => 'Test',
            "email" => 'test@test.com',
            "userType" => 'admin',
            "password" => 'userTest',
            "passwordConfirmation" => 'userTest',
            "teamId" => $team->id
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $this->assertDatabaseCount('users', 2);

        $response->assertJson(['message' => 'Unauthorized'])->assertStatus(403);
    }

    public function test_user_password_does_not_match_with_the_confirmed_one()
    {
        $superAdmin = User::find(1);
        Passport::actingAs($superAdmin, 'api');

        $userData = [
            "name" => 'Test',
            "email" => 'test@test.com',
            "userType" => 'player',
            "password" => 'userTest',
            "passwordConfirmation" => 'userTestt',
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseEmpty('oauth_access_tokens');

        $response->assertJson(['message' => 'Passwords do not match'])->assertStatus(422);
    }

    public function test_user_is_logged_out_successfully()
    {
        $token = User::factory()->create()->createToken('Testing token')->accessToken;

        $response = $this->postJson(route('api.auth.logout'), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $this->assertDatabaseHas('oauth_access_tokens', [
            'revoked' => true
        ]);
        $response->assertJson(['message' => 'User is logged out successfully'])->assertStatus(200);
    }
}
