<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $superAdmin = User::find(1);
        $adminRole = Role::findByName('admin', 'web');
        $this->admin = User::factory()->create()->assignRole($adminRole);

        Passport::actingAs($superAdmin, 'api');
    }

    public function test_admin_users_are_retrieved_successfully()
    {
        $response = $this->getJson(route('api.admin.index'));

        $response->assertJson(['message' => 'Admins are retrieved successfully'])->assertStatus(200);
    }

    public function test_admin_cannot_get_the_list_of_all_admin_users()
    {
        Passport::actingAs($this->admin, 'api');

        $response = $this->getJson(route('api.admin.index'));

        $response->assertJson(['message' => 'Unauthorized'])->assertStatus(403);
    }

    public function test_admin_is_retrieved_successfully()
    {
        $response = $this->getJson(route('api.admin.show', ['adminId' => 2]));

        $response->assertJson(['message' => 'Admin is retrieved successfully'])->assertStatus(200);
    }

    public function test_admin_is_updated_successfully()
    {
        $adminData = [
            'name' => 'Admin test update',
            'email' => 'adminUpdate@test.com'
        ];
        $response = $this->patchJson(route('api.admin.update', ['adminId' => 2]), $adminData);

        $this->assertDatabaseHas('users', [
            'name' => 'Admin test update',
            'email' => 'adminUpdate@test.com'
        ]);
        $response->assertJson(['message' => 'Admin is updated successfully'])->assertStatus(201);
    }

    public function test_admin_is_deleted_softly()
    {
        $response = $this->deleteJson(route('api.admin.destroy', ['adminId' => 2]));

        $this->assertSoftDeleted($this->admin);
        $response->assertJson(['message' => 'Admin is softly deleted'])->assertStatus(200);
    }
}
