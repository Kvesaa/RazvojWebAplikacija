<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Airport;
use App\Models\Airline;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleBasedPermissionsTest extends TestCase
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

        // Create roles
        $readerRole = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $authorRole = Role::create(['name' => 'author', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        // Assign permissions to roles
        $readerRole->givePermissionTo(['read-flight', 'read-airport', 'read-airline']);
        $authorRole->givePermissionTo(['read-flight', 'create-flight', 'read-airport', 'create-airport', 'read-airline', 'create-airline']);
        $adminRole->givePermissionTo($permissions);

        // Create users
        $this->reader = User::create([
            'name' => 'Reader User',
            'email' => 'reader@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $this->reader->assignRole('reader');

        $this->author = User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $this->author->assignRole('author');

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $this->admin->assignRole('admin');
    }

    public function test_reader_can_read_but_not_create_flights()
    {
        // Reader can read flights
        $response = $this->actingAs($this->reader)
            ->getJson('/api/v1/flights');
        $response->assertStatus(200);

        // Reader cannot create flights
        $response = $this->actingAs($this->reader)
            ->postJson('/api/v1/flights', [
                'flightno' => 'AA100',
                'from' => 1,
                'to' => 2,
                'departure' => '2023-01-01 10:00:00',
                'arrival' => '2023-01-01 14:00:00',
                'airline_id' => 1,
                'airplane_id' => 1,
            ]);
        $response->assertStatus(403);
    }

    public function test_author_can_read_and_create_flights()
    {
        // Create required dependencies
        Airport::create(['iata' => 'LAX', 'icao' => 'KLAX', 'name' => 'Los Angeles']);
        Airport::create(['iata' => 'JFK', 'icao' => 'KJFK', 'name' => 'New York']);
        Airline::create(['iata' => 'AA', 'airlinename' => 'American Airlines', 'base_airport' => 1]);

        // Author can read flights
        $response = $this->actingAs($this->author)
            ->getJson('/api/v1/flights');
        $response->assertStatus(200);

        // Author can create flights
        $response = $this->actingAs($this->author)
            ->postJson('/api/v1/flights', [
                'flightno' => 'AA100',
                'from' => 1,
                'to' => 2,
                'departure' => '2023-01-01 10:00:00',
                'arrival' => '2023-01-01 14:00:00',
                'airline_id' => 1,
                'airplane_id' => 1,
            ]);
        $response->assertStatus(201);

        // Author cannot update flights
        $response = $this->actingAs($this->author)
            ->putJson('/api/v1/flights/1', [
                'flightno' => 'AA101',
            ]);
        $response->assertStatus(403);
    }

    public function test_admin_has_full_crud_access()
    {
        // Create required dependencies
        Airport::create(['iata' => 'LAX', 'icao' => 'KLAX', 'name' => 'Los Angeles']);
        Airport::create(['iata' => 'JFK', 'icao' => 'KJFK', 'name' => 'New York']);
        Airline::create(['iata' => 'AA', 'airlinename' => 'American Airlines', 'base_airport' => 1]);

        // Admin can create flights
        $response = $this->actingAs($this->admin)
            ->postJson('/api/v1/flights', [
                'flightno' => 'AA100',
                'from' => 1,
                'to' => 2,
                'departure' => '2023-01-01 10:00:00',
                'arrival' => '2023-01-01 14:00:00',
                'airline_id' => 1,
                'airplane_id' => 1,
            ]);
        $response->assertStatus(201);

        // Admin can update flights
        $response = $this->actingAs($this->admin)
            ->putJson('/api/v1/flights/1', [
                'flightno' => 'AA101',
            ]);
        $response->assertStatus(200);

        // Admin can delete flights
        $response = $this->actingAs($this->admin)
            ->deleteJson('/api/v1/flights/1');
        $response->assertStatus(204);

        // Verify flight is deleted
        $this->assertDatabaseMissing('flights', ['id' => 1]);
    }

    public function test_role_permission_matrix()
    {
        $testCases = [
            ['user' => $this->reader, 'can_read' => true, 'can_create' => false, 'can_update' => false, 'can_delete' => false],
            ['user' => $this->author, 'can_read' => true, 'can_create' => true, 'can_update' => false, 'can_delete' => false],
            ['user' => $this->admin, 'can_read' => true, 'can_create' => true, 'can_update' => true, 'can_delete' => true],
        ];

        foreach ($testCases as $case) {
            $user = $case['user'];
            
            // Test read permission
            $response = $this->actingAs($user)->getJson('/api/v1/flights');
            $expectedStatus = $case['can_read'] ? 200 : 403;
            $response->assertStatus($expectedStatus);

            // Test create permission
            $response = $this->actingAs($user)->postJson('/api/v1/flights', [
                'flightno' => 'TEST',
                'from' => 1,
                'to' => 2,
                'departure' => '2023-01-01 10:00:00',
                'arrival' => '2023-01-01 14:00:00',
                'airline_id' => 1,
                'airplane_id' => 1,
            ]);
            $expectedStatus = $case['can_create'] ? 201 : 403;
            $response->assertStatus($expectedStatus);
        }
    }
}




