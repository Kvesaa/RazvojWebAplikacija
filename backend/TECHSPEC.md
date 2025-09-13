# Technical Specification - DZ 4.1 Basic Authentication

## HTTP Basic Authentication Implementation

### Overview
The API implements HTTP Basic Authentication for v1 endpoints, providing secure access control for write operations while maintaining public read access for airport and airline resources.

### Authentication Flow

1. **Public Access (No Authentication Required):**
   - `GET /api/v1/airport` - List all airports
   - `GET /api/v1/airport/{id}` - Show specific airport
   - `GET /api/v1/airline` - List all airlines
   - `GET /api/v1/airline/{id}` - Show specific airline

2. **Protected Access (HTTP Basic Auth Required):**
   - All POST, PUT, DELETE operations on airport/airline
   - All operations on other resources (flights, passengers, etc.)

### Implementation Details

#### Middleware Configuration
```php
// routes/api.php
Route::middleware(['auth.basic', 'rolematrix'])->group(function () {
    // Protected write operations
    Route::post('airport', [AirportController::class, 'store']);
    Route::put('airport/{id}', [AirportController::class, 'update']);
    Route::delete('airport/{id}', [AirportController::class, 'destroy']);
    // ... other protected routes
});
```

#### Role-Based Access Control
The system enforces role-based permissions using the RoleMatrix middleware:

- **reader:** GET operations only
- **author:** GET + POST operations  
- **admin:** Full CRUD operations

#### Demo Account
- **Email:** `basic_user@example.com`
- **Password:** `basic_pass`
- **Role:** admin (full access to all operations)

### Testing Steps

1. **Test Public Access:**
   ```bash
   curl http://127.0.0.1:8000/api/v1/airport
   # Expected: 200 OK with airport data
   ```

2. **Test Protected Access (No Auth):**
   ```bash
   curl -X POST http://127.0.0.1:8000/api/v1/airport \
        -H "Content-Type: application/json" \
        -d '{"iata":"TEST","icao":"KTST","name":"Test Airport"}'
   # Expected: 401 Unauthorized
   ```

3. **Test Protected Access (With Auth):**
   ```bash
   curl -X POST http://127.0.0.1:8000/api/v1/airport \
        -H "Content-Type: application/json" \
        -H "Authorization: Basic $(echo -n 'basic_user@example.com:basic_pass' | base64)" \
        -d '{"iata":"TEST","icao":"KTST","name":"Test Airport"}'
   # Expected: 201 Created with airport data
   ```

4. **Test Role Restrictions:**
   ```bash
   # Using reader credentials (should fail on POST)
   curl -X POST http://127.0.0.1:8000/api/v1/airport \
        -H "Content-Type: application/json" \
        -H "Authorization: Basic $(echo -n 'reader@example.com:password' | base64)" \
        -d '{"iata":"TEST","icao":"KTST","name":"Test Airport"}'
   # Expected: 403 Forbidden for role: reader
   ```

### Security Considerations

1. **HTTPS Required:** HTTP Basic Auth sends credentials in base64 encoding, which is easily decoded. Production deployments must use HTTPS.

2. **Credential Management:** Demo credentials are for testing only. Production systems should use strong, unique passwords.

3. **Role Validation:** The RoleMatrix middleware validates user roles against allowed HTTP methods, preventing privilege escalation.

### Database Schema

The authentication system uses Laravel's built-in user management with Spatie Laravel Permission:

- `users` table: Stores user credentials and basic information
- `roles` table: Defines available roles (reader, author, admin)
- `permissions` table: Defines granular permissions
- `model_has_roles` table: Links users to roles
- `role_has_permissions` table: Links roles to permissions

### Error Responses

- **401 Unauthorized:** Missing or invalid Basic Auth credentials
- **403 Forbidden:** Valid credentials but insufficient role permissions
- **422 Unprocessable Entity:** Valid authentication but invalid request data
