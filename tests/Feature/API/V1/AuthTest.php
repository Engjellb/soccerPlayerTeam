<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_is_logged_in_successfully()
    {
        $userCredentialsDataTest = [
            'email' => 'admin@test.com',
            'password' => 'adminTest'
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
        $userData = [
            "name" => 'Test',
            "email" => 'test@test.com',
            "password" => 'userTest',
            "passwordConfirmation" => 'userTest'
        ];

        $response = $this->postJson(route('api.auth.register'), $userData);

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('oauth_access_tokens', 1);

        $response->assertJson(['message' => 'User is registered successfully'])->assertStatus(201);
    }

    public function test_user_password_does_not_match_with_the_confirmed_one()
    {
        $userData = [
            "name" => 'Test',
            "email" => 'test@test.com',
            "password" => 'userTest',
            "passwordConfirmation" => 'userTestt'
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
