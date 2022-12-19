<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_password_is_hashed_when_is_inserted()
    {
        $user = User::factory()->create();

        $this->assertStringStartsWith('$2y$', $user->password);
    }
}
