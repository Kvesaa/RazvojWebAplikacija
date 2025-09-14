# AeroAdmin - Airline Management System

A complete airline management system with Laravel backend API and Nuxt 3 frontend.

## Project Overview

AeroAdmin is an airline management system that lets you manage flights, passengers, bookings, and airline operations.

## Project Structure

```
RazvojWebAplikacija/
├── backend/          # Laravel API Backend
├── frontend/         # Nuxt 3 Frontend
└── README.md         # This file
```

## Tech Stack

### Backend
- **Framework:** Laravel 10
- **Language:** PHP 8.2+
- **Database:** SQLite
- **Authentication:** HTTP Basic Auth (v1) + Laravel Sanctum (v2)
- **Authorization:** Spatie Laravel Permission
- **Documentation:** Scribe v4
- **Testing:** PHPUnit

### Frontend
- **Framework:** Nuxt 3
- **Language:** TypeScript
- **Styling:** Custom CSS
- **API Integration:** RESTful API calls

## Quick Start

### Prerequisites
- PHP 8.2+
- Node.js 18+
- Composer
- npm/yarn/pnpm

### Backend Setup

1. **Navigate to backend:**
   ```bash
   cd backend
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Environment setup:**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Database setup:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start server:**
   ```bash
   php artisan serve --port 8000
   ```

### Frontend Setup

1. **Navigate to frontend:**
   ```bash
   cd frontend
   ```

2. **Install dependencies:**
   ```bash
   npm install
   ```

3. **Start development server:**
   ```bash
   npm run dev
   ```

## Access Points

- **Frontend:** http://localhost:3000
- **Backend API:** http://127.0.0.1:8000
- **API Documentation:** http://127.0.0.1:8000/api/docs

## Authentication

### API v1 - Basic Authentication
- **Public:** GET `/api/v1/airport`, GET `/api/v1/airline`
- **Protected:** All other v1 routes require HTTP Basic Auth
- **Demo user:** `basic_user@example.com` / `basic_pass`

### API v2 - Sanctum Token Authentication
- **Token endpoint:** POST `/api/token`
- **Usage:** Include `Authorization: Bearer <token>` header
- **Demo users:**
  - `reader@example.com` / `password` (read-only)
  - `author@example.com` / `password` (read + create)
  - `admin@example.com` / `password` (full access)

## Features

### Dashboard
- Real-time statistics
- Recent flights overview
- Quick actions

### Flight Management
- Create, edit, view, delete flights
- Airport and airline selection
- Date validation
- Flight details with passenger bookings

### Passenger Management
- Complete passenger profiles
- Contact information
- Passport details
- Booking history

### Booking Management
- Flight reservations
- Seat assignment
- Price management
- Passenger-flight linking

## Testing

Run backend tests:
```bash
cd backend
php artisan test
```

## Documentation

- **Backend API:** See `backend/README.md`
- **Frontend:** See `frontend/README.md`
- **API Docs:** Available at `/api/docs` when backend is running

## Tasks Completed

- **DZ 4.1** - Basic Authentication for API v1
- **DZ 4.2** - Roles & Permissions with Spatie
- **DZ 4.3** - OAuth/OAuth2 + Sanctum for API v2
- **DZ 3.2** - API Documentation with Scribe
- **Frontend** - Complete Nuxt 3 application
- **Integration** - Full-stack application

## Notes

- Database is seeded with sample data
- All authentication methods are implemented and tested
- API documentation is auto-generated and interactive
- Frontend is fully responsive and connected to backend
