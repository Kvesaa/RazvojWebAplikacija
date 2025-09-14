<template>
  <div class="bookings-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">📋</span>
          Bookings
        </h1>
        <p>Manage flight bookings and reservations</p>
      </div>
    </div>

    <!-- Search and filters -->
    <div class="card mb-4">
      <form class="search-form">
        <div class="d-flex gap-3 flex-wrap">
          <div class="form-group">
            <label class="form-label">Search by booking ID</label>
            <input 
              v-model="filters.booking_id" 
              type="text" 
              class="form-control" 
              placeholder="Enter booking ID..."
            />
          </div>
          <div class="form-group">
            <label class="form-label">Search by passport number</label>
            <input 
              v-model="filters.passenger_id" 
              type="text" 
              class="form-control" 
              placeholder="Enter passport number..."
            />
          </div>
          <div class="form-group">
            <label class="form-label">Search by flight number</label>
            <input 
              v-model="filters.flight_id" 
              type="text" 
              class="form-control" 
              placeholder="Enter flight number..."
            />
          </div>
          <div class="form-group d-flex align-items-end">
            <button type="submit" class="btn btn-primary">
              🔍 Search
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title">📋 All Bookings ({{ filteredBookings.length }})</h2>
        <div class="d-flex gap-2">
          <NuxtLink to="/bookings/new" class="btn btn-success">
            📋 Add New Booking
          </NuxtLink>
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Passport No.</th>
              <th>Flight No.</th>
              <th>Seat</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="booking in filteredBookings" :key="booking.booking_id">
              <td>
                <NuxtLink :to="`/bookings/${booking.booking_id}`" class="nav-link">
                  <strong>{{ booking.booking_id }}</strong>
                </NuxtLink>
              </td>
              <td>{{ getPassportNumber(booking.passenger_id) }}</td>
              <td>{{ getFlightNumber(booking.flight_id) }}</td>
              <td>{{ booking.seat || 'N/A' }}</td>
              <td>${{ booking.price || '0.00' }}</td>
              <td>
                <div class="d-flex gap-1">
                  <NuxtLink :to="`/bookings/${booking.booking_id}`" class="btn btn-info btn-sm">
                    <span class="icon">ℹ</span>
                  </NuxtLink>
                  <NuxtLink :to="`/bookings/${booking.booking_id}/edit`" class="btn btn-warning btn-sm">
                    <span class="icon">✂</span>
                  </NuxtLink>
                  <button @click="deleteBooking(booking.booking_id)" class="btn btn-danger btn-sm">
                    <span class="icon">❌</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="!bookings || bookings.length === 0">
              <td colspan="6" class="text-center text-muted py-4">
                No bookings found. <NuxtLink to="/bookings/new" class="btn btn-primary btn-sm">Add your first booking</NuxtLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()

// get bookings
const { data: bookings, refresh } = await useAsyncData(
  'bookings',
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

// get flights
const { data: flights } = await useAsyncData(
  'flights-for-bookings',
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

// get passengers
const { data: passengers } = await useAsyncData(
  'passengers-for-bookings',
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

// Client-side filters
const filters = reactive({
  booking_id: '',
  passenger_id: '',
  flight_id: ''
})

// Filtered bookings based on search criteria
const filteredBookings = computed(() => {
  if (!bookings.value) return []
  
  return bookings.value.filter(b => {
    const bookingIdMatch = !filters.booking_id || 
      b.booking_id.toString().includes(filters.booking_id)
    const passengerMatch = !filters.passenger_id || 
      b.passenger_id.toString().includes(filters.passenger_id)
    const flightMatch = !filters.flight_id || 
      b.flight_id.toString().includes(filters.flight_id)
    
    return bookingIdMatch && passengerMatch && flightMatch
  })
})

// Function to get flight number by ID
function getFlightNumber(flightId: number): string {
  const flight = flights.value?.find(f => f.flight_id === flightId)
  return flight ? flight.flightno : `Flight ${flightId}`
}

// Function to get passport number by passenger ID
function getPassportNumber(passengerId: number): string {
  const passenger = passengers.value?.find(p => p.passenger_id === passengerId)
  return passenger ? passenger.passportno : `Passenger ${passengerId}`
}

async function deleteBooking(bookingId: number) {
  if (confirm('Are you sure you want to delete this booking?')) {
    try {
      await $fetch(`/booking/${bookingId}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      await refresh()
      alert('Booking deleted successfully!')
    } catch (error) {
      console.error('Failed to delete booking:', error)
      alert('Failed to delete booking. Please try again.')
    }
  }
}
</script>