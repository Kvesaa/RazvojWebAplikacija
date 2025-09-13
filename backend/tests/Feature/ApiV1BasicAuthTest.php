<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Airport;
use App\Models\Airline;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiV1BasicAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create permissions
        $permissions = [
            'read-flight', 'create-flight', 'update-flight', 'delete-flight',
            'read-airport', 'create-airport', 'update-airport', 'delete-airport',
            'read-airline', 'create-airline', 'update-airline', 'delete-airline',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create admin role
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo($permissions);
        
        // Create basic auth user with admin role
        $user = User::create([
            'name' => 'Basic Auth User',
            'email' => 'basic_user@example.com',
            'password' => bcrypt('basic_pass'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('admin');
    }

    public function test_unauthenticated_can_read_airport_and_airline()
    {
        // Create test data
        Airport::create([
            'iata' => 'LAX',
            'icao' => 'KLAX',
            'name' => 'Los Angeles International Airport',
        ]);

        Airline::create([
            'iata' => 'AA',
            'airlinename' => 'American Airlines',
            'base_airport' => 1,
        ]);

        // Test public airport access
        $response = $this->getJson('/api/v1/airport');
        $response->assertStatus(200);
        $response->assertJsonCount(1);

        // Test public airline access
        $response = $this->getJson('/api/v1/airline');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_unauthenticated_cannot_access_protected_endpoints()
    {
        // Test protected airport write operations
        $response = $this->postJson('/api/v1/airport', [
            'iata' => 'JFK',
            'icao' => 'KJFK',
            'name' => 'John F. Kennedy International Airport',
        ]);
        $response->assertStatus(401);

        // Test protected flights endpoint
        $response = $this->getJson('/api/v1/flights');
        $response->assertStatus(401);

        // Test protected airline write operations
        $response = $this->postJson('/api/v1/airline', [
            'iata' => 'UA',
            'airlinename' => 'United Airlines',
            'base_airport' => 1,
        ]);
        $response->assertStatus(401);
    }

    public function test_basic_auth_user_can_access_protected_endpoints()
    {
        // Test airport creation with basic auth
        $response = $this->withBasicAuth('basic_user@example.com', 'basic_pass')
            ->postJson('/api/v1/airport', [
                'iata' => 'JFK',
                'icao' => 'KJFK',
                'name' => 'John F. Kennedy International Airport',
            ]);
        $response->assertStatus(201);
        $response->assertJson([
            'iata' => 'JFK',
            'icao' => 'KJFK',
            'name' => 'John F. Kennedy International Airport',
        ]);

        // Test airport update with basic auth
        $response = $this->withBasicAuth('basic_user@example.com', 'basic_pass')
            ->putJson('/api/v1/airport/1', [
                'iata' => 'JFK',
                'icao' => 'KJFK',
                'name' => 'John F. Kennedy International Airport - Updated',
            ]);
        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'John F. Kennedy International Airport - Updated',
        ]);

        // Test flights access with basic auth
        $response = $this->withBasicAuth('basic_user@example.com', 'basic_pass')
            ->getJson('/api/v1/flights');
        $response->assertStatus(200);
    }

    public function test_basic_auth_user_can_delete_airport()
    {
        // Create airport first
        Airport::create([
            'iata' => 'LAX',
            'icao' => 'KLAX',
            'name' => 'Los Angeles International Airport',
        ]);

        // Test airport deletion with basic auth
        $response = $this->withBasicAuth('basic_user@example.com', 'basic_pass')
            ->deleteJson('/api/v1/airport/1');
        $response->assertStatus(204);

        // Verify airport is deleted
        $this->assertDatabaseMissing('airport', ['airport_id' => 1]);
    }

    public function test_invalid_basic_auth_credentials()
    {
        $response = $this->withBasicAuth('invalid@example.com', 'wrong_password')
            ->postJson('/api/v1/airport', [
                'iata' => 'JFK',
                'icao' => 'KJFK',
                'name' => 'John F. Kennedy International Airport',
            ]);
        $response->assertStatus(401);
    }
}



