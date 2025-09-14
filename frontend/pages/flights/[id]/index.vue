<template>
  <div class="flight-detail-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">✈️</span>
          Flight Details
        </h1>
        <p>View flight information and passenger bookings</p>
      </div>
    </div>

    <div v-if="pending" class="text-center py-4">
      <div class="spinner"></div>
      <p class="text-muted mt-2">Loading flight details...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      ❌ Error loading flight: {{ error.message }}
    </div>

    <div v-else-if="!flight" class="alert alert-warning">
      Flight not found.
    </div>

    <div v-else class="card">
      <div class="card-header">
        <h2 class="card-title">Flight Information</h2>
      </div>
      <div class="card-body">
        <div class="detail-row">
          <span class="detail-label">Flight Number:</span>
          <span class="detail-value">{{ flight.flightno }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">From:</span>
          <span class="detail-value">{{ getAirportName(flight.from) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">To:</span>
          <span class="detail-value">{{ getAirportName(flight.to) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Departure:</span>
          <span class="detail-value">{{ formatDate(flight.departure) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Arrival:</span>
          <span class="detail-value">{{ formatDate(flight.arrival) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Airline:</span>
          <span class="detail-value">{{ getAirlineName(flight.airline_id) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Airplane:</span>
          <span class="detail-value">{{ getAirplaneInfo(flight.airplane_id) }}</span>
        </div>
      </div>
      <div class="card-footer form-actions">
        <NuxtLink :to="`/flights/${flightId}/edit`" class="btn btn-warning">
          ✂ Edit Flight
        </NuxtLink>
        <button @click="onDelete" class="btn btn-danger">
          ❌ Delete Flight
        </button>
        <NuxtLink to="/flights" class="btn btn-secondary">
          ← Back to Flights
        </NuxtLink>
      </div>
    </div>

    <!-- Passengers on This Flight -->
    <div v-if="flight && bookings && bookings.length > 0" class="card mt-4">
      <div class="card-header">
        <h2 class="card-title">Passengers on This Flight ({{ bookings.length }})</h2>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Passenger</th>
                <th>Seat</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="booking in bookings" :key="booking.booking_id">
                <td>{{ getPassengerName(booking.passenger_id) }}</td>
                <td>{{ booking.seat || 'N/A' }}</td>
                <td>${{ booking.price || '0.00' }}</td>
                <td>
                  <NuxtLink :to="`/passengers/${booking.passenger_id}`" class="btn btn-info btn-sm">
                    <span class="icon">ℹ</span>
                  </NuxtLink>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute, useRouter, useRuntimeConfig, useAsyncData } from '#imports'

interface Flight {
  flight_id: number
  flightno: string
  from: number
  to: number
  departure: string
  arrival: string
  airline_id: number
  airplane_id: number
}

interface Airport {
  airport_id: number
  iata: string
  icao: string
  name: string
}

interface Airline {
  airline_id: number
  iata: string
  airlinename: string
}

interface Airplane {
  airplane_id: number
  capacity: number
  type_id: number
  airline_id: number
}

interface Booking {
  booking_id: number
  passenger_id: number
  flight_id: number
  seat: string
  price: number
}

interface Passenger {
  passenger_id: number
  passportno: string
  firstname: string
  lastname: string
}

const route = useRoute()
const router = useRouter()
const config = useRuntimeConfig()
const flightId = parseInt(route.params.id as string)

const {
  data: flight,
  pending,
  error,
  refresh: refreshFlight
} = await useAsyncData<Flight>(
  `flight-${flightId}`,
  () => $fetch(`/flights/${flightId}`, {
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => null
  }
)

// get airports
const {
  data: airports,
  refresh: refreshAirports
} = await useAsyncData<Airport[]>(
  'airports-for-flight-detail',
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

// get airlines
const {
  data: airlines,
  refresh: refreshAirlines
} = await useAsyncData<Airline[]>(
  'airlines-for-flight-detail',
  () => $fetch('/airline', {
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
} = await useAsyncData<Airplane[]>(
  'airplanes-for-flight-detail',
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

// Fetch bookings for this flight
const {
  data: bookings,
  refresh: refreshBookings
} = await useAsyncData<Booking[]>(
  `bookings-for-flight-${flightId}`,
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

// get passengers
const {
  data: passengers,
  refresh: refreshPassengers
} = await useAsyncData<Passenger[]>(
  'passengers-for-flight-detail',
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

// Filter bookings for this flight
const flightBookings = computed(() => {
  return bookings.value?.filter(b => b.flight_id === flightId) || []
})

// Function to get airport name by ID
function getAirportName(airportId: number): string {
  const airport = airports.value?.find(a => a.airport_id === airportId)
  return airport ? `${airport.iata} - ${airport.name}` : `Airport ${airportId}`
}

// Function to get airline name by ID
function getAirlineName(airlineId: number): string {
  const airline = airlines.value?.find(a => a.airline_id === airlineId)
  return airline ? airline.airlinename : `Airline ${airlineId}`
}

// Function to get airplane info by ID
function getAirplaneInfo(airplaneId: number): string {
  const airplane = airplanes.value?.find(a => a.airplane_id === airplaneId)
  return airplane ? `Airplane ${airplaneId} (${airplane.capacity} seats)` : `Airplane ${airplaneId}`
}

// Function to get passenger name by ID
function getPassengerName(passengerId: number): string {
  const passenger = passengers.value?.find(p => p.passenger_id === passengerId)
  return passenger ? `${passenger.firstname} ${passenger.lastname}` : `Passenger ${passengerId}`
}

// Date formatter
function formatDate(dt: string): string {
  return dt ? new Date(dt).toLocaleString() : ''
}

async function onDelete() {
  if (confirm('Are you sure you want to delete this flight? This will also delete all associated bookings.')) {
    try {
      await $fetch(`/flights/${flightId}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      alert('Flight deleted successfully!')
      router.push('/flights')
    } catch (error) {
      console.error('Failed to delete flight:', error)
      alert('Failed to delete flight. Please try again.')
    }
  }
}
</script>
