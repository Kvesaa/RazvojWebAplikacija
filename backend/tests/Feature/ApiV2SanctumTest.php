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

class ApiV2SanctumTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create permissions and roles
        $permissions = [
            'read-flight', 'create-flight', 'update-flight', 'delete-flight',
            'read-airport', 'create-airport', 'update-airport', 'delete-airport',
            'read-airline', 'create-airline', 'update-airline', 'delete-airline',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $readerRole = Role::create(['name' => 'reader', 'guard_name' => 'web']);
        $readerRole->givePermissionTo(['read-flight', 'read-airport', 'read-airline']);

        // Create user
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $this->user->assignRole('reader');
    }

    public function test_unauthenticated_cannot_access_v2_endpoints()
    {
        $response = $this->getJson('/api/v2/flights');
        $response->assertStatus(401);

        $response = $this->getJson('/api/v2/airport');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_access_v2_endpoints()
    {
        // Create test data
        Airport::create([
            'iata' => 'LAX',
            'icao' => 'KLAX',
            'name' => 'Los Angeles International Airport',
        ]);

        // Get Sanctum token
        $token = $this->user->createToken('test-token')->plainTextToken;

        // Test authenticated access
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson('/api/v2/airport');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_token_creation_endpoint()
    {
        // Test token creation
        $response = $this->actingAs($this->user)
            ->postJson('/api/token');

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        
        $token = $response->json('token');
        $this->assertNotEmpty($token);
    }

    public function test_token_revocation()
    {
        // Create token
        $token = $this->user->createToken('test-token')->plainTextToken;

        // Test token revocation
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->deleteJson('/api/token');

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Token revoked successfully']);

        // Verify token is revoked
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson('/api/v2/airport');

        $response->assertStatus(401);
    }

    public function test_invalid_token_access()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid-token',
            'Accept' => 'application/json',
        ])->getJson('/api/v2/airport');

        $response->assertStatus(401);
    }

    public function test_v2_endpoints_require_sanctum_auth()
    {
        $endpoints = [
            '/api/v2/airport',
            '/api/v2/airline',
            '/api/v2/flights',
            '/api/v2/airplane',
            '/api/v2/booking',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->getJson($endpoint);
            $response->assertStatus(401);
        }
    }

    public function test_v2_endpoints_work_with_valid_token()
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

        $token = $this->user->createToken('test-token')->plainTextToken;

        $endpoints = [
            '/api/v2/airport',
            '/api/v2/airline',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->getJson($endpoint);

            $response->assertStatus(200);
        }
    }
}



