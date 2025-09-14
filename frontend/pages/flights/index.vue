<template>
  <div class="flights-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">✈️</span>
          Flight Management
        </h1>
        <p>Manage all your airline flights</p>
      </div>
    </div>

    <div class="card">
      <form class="search-form" @submit.prevent="searchFlights">
        <div class="form-row">
          <div class="form-group">
            <input 
              type="text" 
              v-model="filters.flight" 
              placeholder="Flight Number" 
              class="form-control"
            />
          </div>
          <div class="form-group">
            <input 
              type="text" 
              v-model="filters.from" 
              placeholder="From Airport" 
              class="form-control"
            />
          </div>
          <div class="form-group">
            <input 
              type="text" 
              v-model="filters.to" 
              placeholder="To Airport" 
              class="form-control"
            />
          </div>
          <div class="form-group">
            <input 
              type="date" 
              v-model="filters.departure" 
              placeholder="Departure Date" 
              class="form-control"
            />
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              🔍 Search Flights
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">📋 All Flights ({{ filteredFlights.length }})</h2>
        <div class="d-flex gap-2">
          <button @click="refreshData" class="btn btn-info btn-sm" :disabled="pending">
            <span v-if="pending" class="spinner"></span>
            {{ pending ? 'Loading...' : '🔄 Refresh' }}
          </button>
          <NuxtLink to="/flights/new" class="btn btn-success">
            ✈️ Add New Flight
          </NuxtLink>
        </div>
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
            <tr v-for="flight in filteredFlights" :key="flight.flight_id">
              <td>
                <NuxtLink :to="`/flights/${flight.flight_id}`" class="nav-link">
                  <strong>{{ flight.flightno }}</strong>
                </NuxtLink>
              </td>
              <td>{{ getAirportName(flight.from) }}</td>
              <td>{{ getAirportName(flight.to) }}</td>
              <td>{{ formatDate(flight.departure) }}</td>
              <td>{{ formatDate(flight.arrival) }}</td>
              <td>
                <div class="d-flex gap-1">
                  <NuxtLink :to="`/flights/${flight.flight_id}`" class="btn btn-info btn-sm">
                    <span class="icon">ℹ</span>
                  </NuxtLink>
                  <NuxtLink :to="`/flights/${flight.flight_id}/edit`" class="btn btn-warning btn-sm">
                    <span class="icon">✂</span>
                  </NuxtLink>
                  <button @click="deleteFlight(flight.flight_id)" class="btn btn-danger btn-sm">
                    <span class="icon">❌</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="filteredFlights.length === 0">
              <td colspan="6" class="text-center text-muted py-4">
                No flights found. <NuxtLink to="/flights/new" class="btn btn-primary btn-sm">Create your first flight</NuxtLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">Showing {{ filteredFlights.length }} flights</span>
        <div class="pagination">
          <button class="btn btn-outline btn-sm" disabled>← Previous</button>
          <span class="page-number mx-2">1</span>
          <button class="btn btn-outline btn-sm" disabled>Next →</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'
import { computed, reactive } from 'vue'
import { useAsyncData, useRuntimeConfig } from '#imports'
import StatCard from '~/components/dashboard/StatCard.vue'

type Flight = {
  flight_id: number
  flightno: string
  from: number
  to: number
  departure: string
  arrival: string
  airline_id: number
  airplane_id: number
}

const route  = useRoute()
const config = useRuntimeConfig()

// dynamic key so useAsyncData re-runs on every navigation to /flights
const dataKey = computed(() => `flights-${route.fullPath}`)

// get flights from api
const {
  data: flights,
  pending,
  error,
  refresh
} = await useAsyncData<Flight[]>(
  'flights',
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

// get airports
const {
  data: airports,
  refresh: refreshAirports
} = await useAsyncData(
  'airports',
  () => $fetch('/airport', {
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => []
  }
)

// client-side filters
const filters = reactive({
  flight:   '',
  from:     '',
  to:       '',
  departure:'',
  arrival:  '',
})

const filteredFlights = computed(() => {
  return (flights.value || []).filter((f) =>
    (!filters.flight    || f.flightno.toLowerCase().includes(filters.flight.toLowerCase())) &&
    (!filters.from      || String(f.from).includes(filters.from)) &&
    (!filters.to        || String(f.to).includes(filters.to)) &&
    (!filters.departure || f.departure.includes(filters.departure)) &&
    (!filters.arrival   || f.arrival.includes(filters.arrival))
  )
})

// Function to get airport name by ID
function getAirportName(airportId: number): string {
  const airport = airports.value?.find(a => a.airport_id === airportId)
  return airport ? `${airport.iata} - ${airport.name}` : `Airport ${airportId}`
}

function searchFlights() {
  // Search functionality is handled by computed filteredFlights
}

// Add refresh function for the refresh button
async function refreshData() {
  await Promise.all([
    refresh(),
    refreshAirports()
  ])
}

async function deleteFlight(flightId: number) {
  if (confirm('Are you sure you want to delete this flight?')) {
    try {
      await $fetch(`/flights/${flightId}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      
      // Refresh the flights list
      await refresh()
      alert('Flight deleted successfully!')
    } catch (error) {
      console.error('Failed to delete flight:', error)
      alert('Failed to delete flight. Please try again.')
    }
  }
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
.search-form {
  margin-bottom: 0;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr auto;
  gap: 1rem;
  align-items: end;
}

.form-group {
  margin-bottom: 0;
}

.pagination {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.page-number {
  font-weight: bold;
  padding: 0.5rem;
  background: var(--light-bg);
  border-radius: var(--border-radius-sm);
}

@media (max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .d-flex.gap-1 {
    flex-direction: column;
    gap: 0.25rem;
  }
}
</style>
