<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $superAdmin = User::find(1);
        Passport::actingAs($superAdmin, 'api');
    }

    public function test_admin_users_are_retrieved_successfully()
    {
        $response = $this->getJson(route('api.admin.index'));

        $response->assertJson(['message' => 'Admins are retrieved successfully'])->assertStatus(200);
    }

    public function test_admin_cannot_get_the_list_of_all_admin_users()
    {
        $adminRole = Role::findByName('admin', 'web');
        $admin = User::factory()->create()->assignRole($adminRole);
        Passport::actingAs($admin, 'api');

        $response = $this->getJson(route('api.admin.index'));

        $response->assertJson(['message' => 'Unauthorized'])->assertStatus(403);
    }
}
