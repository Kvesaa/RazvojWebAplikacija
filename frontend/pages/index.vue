<template>
  <div class="dashboard">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">✈️</span>
          AeroAdmin Dashboard
        </h1>
        <p>Welcome to your flight management system</p>
      </div>
    </div>

    <!-- Stat cards -->
    <div class="stats-grid">
      <div class="card stat-card">
        <div class="stat-icon">✈️</div>
        <div class="stat-content">
          <h3>{{ flights?.length || 0 }}</h3>
          <p>Active Flights</p>
        </div>
        <NuxtLink to="/flights" class="stat-link">View All</NuxtLink>
      </div>
      
                      <div class="card stat-card">
                        <div class="stat-icon">🛩️</div>
                        <div class="stat-content">
                          <h3>{{ airplanes?.length || 0 }}</h3>
                          <p>Airplanes</p>
                        </div>
                        <button class="stat-link">Manage</button>
                      </div>
                      
                      <div class="card stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-content">
                          <h3>{{ passengers?.length || 0 }}</h3>
                          <p>Passengers</p>
                        </div>
                        <button class="stat-link">View</button>
                      </div>
                      
                      <div class="card stat-card">
                        <div class="stat-icon">📋</div>
                        <div class="stat-content">
                          <h3>{{ bookings?.length || 0 }}</h3>
                          <p>Bookings</p>
                        </div>
                        <button class="stat-link">Manage</button>
                      </div>
    </div>

    <!-- Quick actions -->
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">🚀 Quick Actions</h2>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <NuxtLink to="/flights/new" class="btn btn-primary">
          ✈️ Add Flight
        </NuxtLink>
        <button class="btn btn-outline">📋 Add Booking</button>
        <button class="btn btn-outline">👤 Add Passenger</button>
        <button class="btn btn-outline">🛩️ Add Airplane</button>
      </div>
    </div>

    <!-- Recent Flights -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">📅 Recent Flights</h2>
                        <button @click="refreshAllData" class="btn btn-success btn-sm" :disabled="pending">
                          <span v-if="pending" class="spinner"></span>
                          {{ pending ? 'Loading...' : '🔄 Refresh All' }}
                        </button>
      </div>
      
      <div v-if="pending" class="text-center py-4">
        <div class="spinner"></div>
        <p class="text-muted mt-2">Loading flights...</p>
      </div>
      
      <div v-else-if="error" class="alert alert-danger">
        ❌ Error loading flights: {{ error.message }}
      </div>
      
      <div v-else class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Flight</th>
              <th>From</th>
              <th>To</th>
              <th>Departure</th>
              <th>Arrival</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="flight in flights || []" :key="flight.flight_id">
              <td>
                <NuxtLink :to="`/flights/${flight.flight_id}`" class="nav-link">
                  <strong>{{ flight.flightno }}</strong>
                </NuxtLink>
              </td>
              <td>{{ flight.from }}</td>
              <td>{{ flight.to }}</td>
              <td>{{ formatDate(flight.departure) }}</td>
              <td>{{ formatDate(flight.arrival) }}</td>
              <td>
                <NuxtLink :to="`/flights/${flight.flight_id}`" class="btn btn-info btn-sm">
                  👁️ View
                </NuxtLink>
              </td>
            </tr>
            <tr v-if="!flights || flights.length === 0">
              <td colspan="6" class="text-center text-muted py-4">
                No flights found. <NuxtLink to="/flights/new" class="btn btn-primary btn-sm">Create your first flight</NuxtLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import StatCard from '~/components/dashboard/StatCard.vue'

const config = useRuntimeConfig()

// get flights
const {
  data: flights,
  pending,
  error,
  refresh: refreshFlights
} = await useAsyncData<Flight[]>(
  'dashboard-flights',
  () => $fetch('/flights', { 
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => []
  }
)

// get airplanes
const {
  data: airplanes,
  refresh: refreshAirplanes
} = await useAsyncData(
  'dashboard-airplanes',
  () => $fetch('/airplane', { 
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => []
  }
)

// get passengers
const {
  data: passengers,
  refresh: refreshPassengers
} = await useAsyncData(
  'dashboard-passengers',
  () => $fetch('/passengers', { 
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => []
  }
)

// get bookings
const {
  data: bookings,
  refresh: refreshBookings
} = await useAsyncData(
  'dashboard-bookings',
  () => $fetch('/booking', { 
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => []
  }
)

// Combined refresh function for all dashboard data
async function refreshAllData() {
  await Promise.all([
    refreshFlights(),
    refreshAirplanes(),
    refreshPassengers(),
    refreshBookings()
  ])
}

function formatDate(dateString: string) {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<style scoped>
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  position: relative;
  padding: 1.5rem;
  background: white;
  border-left: 4px solid var(--primary-color);
}

.stat-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.stat-content h3 {
  font-size: 2rem;
  margin: 0 0 0.5rem 0;
  color: var(--primary-color);
}

.stat-link {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: var(--primary-color);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: var(--border-radius-sm);
  text-decoration: none;
  font-size: 0.8rem;
  font-weight: 600;
  transition: var(--transition);
}

@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
}
</style>
