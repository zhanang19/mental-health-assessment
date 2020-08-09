<?php

namespace Tests\Feature;

use App\DaycareFacility;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Tests if admin can read all users.
     * 
     * @return void
     */
    public function test_as_admin_get_all_users()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $this->actingAs(
            User::whereEmail('admin@admin.com')->first()
        );
        
        $this->call('get', '/api/users')
            ->assertOk();
    }

    /**
     * Tests if admin can read a single user.
     * 
     * @return void
     */
    public function test_as_admin_get_a_single_user()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        
        $this->actingAs(
            User::whereEmail('admin@admin.com')->first()
        );
        
        $this->call('get', '/api/users/1')
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => 1
                ]
            ]);
    }

    /**
     * Tests if admin can delete a single user.
     * 
     * @return void
     */
    public function test_as_admin_delete_a_user()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        
        $this->actingAs(
            User::whereEmail('admin@admin.com')->first()
        );
        
        $this->call('delete', '/api/users/2')
            ->assertOk()
            ->assertJson([
                'message' => 'A user was deleted.'
            ]);
    }

    /**
     * Tests if admin can create a new user.
     * 
     * @return void
     */
    public function test_as_admin_create_a_user()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $this->actingAs(
            User::whereEmail('admin@admin.com')->first()
        );

        $facilities = DaycareFacility::all();

        $payload = [
            'daycare_id' => $facilities->random()->id,
            'username' => 'batmanfor3ver',
            'first_name' => 'Bruce',
            'middle_name' => 'Martha',
            'last_name' => 'Wayne',
            'email' => 'batman@mailinator.com',
            'time_zone' => 'America/New_York',
            'password' => bcrypt('password')
        ];

        $this->call('post', '/api/users', $payload)
            ->assertStatus(201);
    }

    /**
     * Tests if admin can update a new user.
     * 
     * @return void
     */
    public function test_as_admin_update_a_user()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();

        $this->actingAs(
            User::whereEmail('admin@admin.com')->first()
        );

        $payload = [
            'first_name' => 'Brucie',
            'middle_name' => 'Martha',
            'last_name' => 'Wayne',
            'email' => 'batman@mailinator.com',
            'time_zone' => 'America/New_York',
            'password' => bcrypt('password')
        ];

        $this->call('put', '/api/users/2', $payload)
            ->assertStatus(204);
    }

    /**
     * Tests if user can read all users.
     * 
     * @return void
     */
    public function test_as_user_get_all_users()
    {
        $this->withoutMiddleware();

        $this->actingAs(
            User::find(2)
        );
        
        $this->call('get', '/api/users')
            ->assertStatus(403);
    }

    /**
     * Tests if user can read a single user.
     * 
     * @return void
     */
    public function test_as_user_get_a_single_user()
    {
        $this->withoutMiddleware();
        
        $this->actingAs(
            User::find(2)
        );
        
        $this->call('get', '/api/users/1')
            ->assertStatus(403);
    }

    /**
     * Tests if user can delete a single user.
     * 
     * @return void
     */
    public function test_as_user_delete_a_user()
    {
        $this->withoutMiddleware();

        $this->actingAs(
            User::find(2)
        );
        
        $this->call('delete', '/api/users/2')
            ->assertStatus(403);
    }

    /**
     * Tests if user can create a new user.
     * 
     * @return void
     */
    public function test_as_user_create_a_user()
    {
        $this->withoutMiddleware();

        $this->actingAs(
            User::find(2)
        );

        $payload = [
            'daycare_id' => DaycareFacility::all()->random()->id,
            'first_name' => 'Bruce',
            'middle_name' => 'Martha',
            'last_name' => 'Wayne',
            'email' => 'batman@mailinator.com',
            'time_zone' => 'America/New_York',
            'password' => bcrypt('password')
        ];

        $this->call('post', '/api/users', $payload)
            ->assertStatus(403);
    }

    /**
     * Tests if user can update a new user.
     * 
     * @return void
     */
    public function test_as_user_update_a_user()
    {
        $this->withoutMiddleware();
        
        $this->actingAs(
            User::find(2)
        );

        $payload = [
            'first_name' => 'Brucie',
            'middle_name' => 'Martha',
            'last_name' => 'Wayne',
            'email' => 'batman@mailinator.com',
            'time_zone' => 'America/New_York',
            'password' => bcrypt('password')
        ];

        $this->call('put', '/api/users/2', $payload)
            ->assertStatus(403);
    }
}
