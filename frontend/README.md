# AeroAdmin Frontend

An airline management system built with Nuxt 3 and Vue.js.

## Features

- **Dashboard** - Overview of flights, passengers, airplanes, and bookings
- **Flight Management** - Create, edit, view, and delete flights
- **Passenger Management** - Manage passenger information and details
- **Booking Management** - Handle flight bookings and reservations
- **Responsive Design** - Works on desktop and mobile devices
- **Real-time Data** - Connected to Laravel backend API

## Prerequisites

- Node.js 18+ 
- npm, pnpm, yarn, or bun
- Backend API running on http://127.0.0.1:8000

## Quick Start

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Start development server:**
   ```bash
   npm run dev
   ```

3. **Access the application:**
   - Frontend: http://localhost:3000
   - Backend API: http://127.0.0.1:8000

## Configuration

The app connects to the Laravel backend API. Make sure the backend is running before starting the frontend.

## Pages

- `/` - Dashboard with statistics
- `/flights` - Flight management
- `/passengers` - Passenger management  
- `/bookings` - Booking management

## Build for Production

```bash
npm run build
npm run preview
```

## Tech Stack

- **Framework:** Nuxt 3
- **Language:** TypeScript
- **Styling:** Custom CSS
- **API:** RESTful API calls to Laravel backend
