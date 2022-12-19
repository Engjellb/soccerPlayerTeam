<?php

namespace Tests\Feature\API\V1;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_is_logged_in_successfully()
    {
        $userCredentialsDataTest = [
            'email' => 'admin@test.com',
            'password' => 'adminTest'
        ];

        $response = $this->postJson(route('auth.login'), $userCredentialsDataTest);

        $this->assertDatabaseCount('oauth_access_tokens', 1);
        $response->assertJson(['message' => 'User is logged in successfully'])->assertStatus(200);
    }

    public function test_user_has_incorrect_credentials()
    {
        $userInvalidCredentialsTest = [
            'email' => 'adminn@test.com',
            'password' => 'adminTest'
        ];

        $response = $this->postJson(route('auth.login'), $userInvalidCredentialsTest);

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

        $response = $this->postJson(route('auth.register'), $userData);

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

        $response = $this->postJson(route('auth.register'), $userData);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseEmpty('oauth_access_tokens');

        $response->assertJson(['message' => 'Passwords do not match'])->assertStatus(422);
    }
}
