# Laravel API Backend

## Prerequisites
- PHP 8.2+
- Composer
- Windows PowerShell (for this setup)

## Quick Start

1. **Navigate to backend directory:**
   ```powershell
   cd backend
   ```

2. **Install dependencies:**
   ```powershell
   composer install
   ```

3. **Environment setup:**
   ```powershell
   copy .env.example .env
   ```

4. **Generate application key:**
   ```powershell
   php artisan key:generate
   ```

5. **Database setup (SQLite):**
   ```powershell
   php artisan migrate:fresh --seed
   ```

6. **Start development server:**
   ```powershell
   php artisan serve --port 8000
   ```

## Authentication

### API v1 - Basic Authentication
- **Public endpoints:** GET `/api/v1/airport`, GET `/api/v1/airline`
- **Protected endpoints:** All other v1 routes require HTTP Basic Auth
- **Demo credentials:** `basic_user@example.com` / `basic_pass`

### API v2 - Sanctum Token Authentication
- **Token issuance:** POST `/api/token`
  ```json
  {
    "email": "admin@example.com",
    "password": "password", 
    "device_name": "dev"
  }
  ```
- **Token usage:** Include `Authorization: Bearer <token>` header
- **Token revocation:** DELETE `/api/token` with Bearer token

## Roles & Permissions

The system uses Spatie Laravel Permission with three roles:

- **reader:** GET operations only
- **author:** GET + POST operations
- **admin:** Full CRUD (GET, POST, PUT, DELETE)

### Seeded Accounts
- `reader@example.com` / `password` (reader role)
- `author@example.com` / `password` (author role)  
- `admin@example.com` / `password` (admin role)
- `basic_user@example.com` / `basic_pass` (admin role, for v1 Basic Auth)

## API Documentation

- **Interactive docs:** http://127.0.0.1:8000/api/docs
- **Alternative URL:** http://127.0.0.1:8000/docs
- **Postman collection:** `public/api/docs/collection.json`
- **OpenAPI spec:** `public/api/docs/openapi.yaml`

## Testing

Run the test suite:
```powershell
php artisan test
```

## Endpoints Summary

### v1 Endpoints (Basic Auth)
- `GET /api/v1/airport` - Public
- `GET /api/v1/airline` - Public
- `POST /api/v1/airport` - Requires Basic Auth + admin role
- All other v1 routes require Basic Auth + appropriate role

### v2 Endpoints (Sanctum)
- All v2 routes require Bearer token + appropriate role
- Same resource structure as v1 but with Sanctum authentication

### Token Management
- `POST /api/token` - Issue new token
- `DELETE /api/token` - Revoke current token