<template>
  <div class="booking-detail-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">📋</span>
          Booking Details
        </h1>
        <p>View booking information and passenger details</p>
      </div>
    </div>

    <div v-if="pending" class="text-center py-4">
      <div class="spinner"></div>
      <p class="text-muted mt-2">Loading booking details...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      ❌ Error loading booking: {{ error.message }}
    </div>

    <div v-else-if="!booking" class="alert alert-warning">
      Booking not found.
    </div>

    <div v-else class="card">
      <div class="card-header">
        <h2 class="card-title">Booking Information</h2>
      </div>
      <div class="card-body">
        <div class="detail-row">
          <span class="detail-label">Booking ID:</span>
          <span class="detail-value">{{ booking.booking_id }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Passenger:</span>
          <span class="detail-value">{{ getPassengerName(booking.passenger_id) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Passport No.:</span>
          <span class="detail-value">{{ getPassportNumber(booking.passenger_id) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Flight:</span>
          <span class="detail-value">{{ getFlightNumber(booking.flight_id) }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Seat:</span>
          <span class="detail-value">{{ booking.seat || 'N/A' }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Price:</span>
          <span class="detail-value">${{ booking.price || '0.00' }}</span>
        </div>
      </div>
      <div class="card-footer form-actions">
        <NuxtLink :to="`/bookings/${booking.booking_id}/edit`" class="btn btn-warning">
          ✂ Edit Booking
        </NuxtLink>
        <button @click="deleteBooking(booking.booking_id)" class="btn btn-danger">
          ❌ Delete Booking
        </button>
        <NuxtLink to="/bookings" class="btn btn-secondary">
          ← Back to Bookings
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute, useRouter, useRuntimeConfig, useAsyncData } from '#imports'

interface Booking {
  booking_id: number
  passenger_id: number
  flight_id: number
  seat: string
  price: number
}

interface Flight {
  flight_id: number
  flightno: string
  from: number
  to: number
  departure: string
  arrival: string
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
const bookingId = parseInt(route.params.id as string)

const {
  data: booking,
  pending,
  error,
  refresh
} = await useAsyncData<Booking>(
  `booking-${bookingId}`,
  () => $fetch(`/booking/${bookingId}`, {
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => null
  }
)

// get flights for dropdown
const {
  data: flights,
  refresh: refreshFlights
} = await useAsyncData<Flight[]>(
  'flights-for-booking-detail',
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

// get passengers for names
const {
  data: passengers,
  refresh: refreshPassengers
} = await useAsyncData<Passenger[]>(
  'passengers-for-booking-detail',
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

// Function to get flight number by ID
function getFlightNumber(flightId: number): string {
  const flight = flights.value?.find(f => f.flight_id === flightId)
  return flight ? flight.flightno : `Flight ${flightId}`
}

// Function to get passenger name by ID
function getPassengerName(passengerId: number): string {
  const passenger = passengers.value?.find(p => p.passenger_id === passengerId)
  return passenger ? `${passenger.firstname} ${passenger.lastname}` : `Passenger ${passengerId}`
}

// Function to get passport number by passenger ID
function getPassportNumber(passengerId: number): string {
  const passenger = passengers.value?.find(p => p.passenger_id === passengerId)
  return passenger ? passenger.passportno : `Passenger ${passengerId}`
}

async function deleteBooking(id: number) {
  if (confirm('Are you sure you want to delete this booking? This action cannot be undone.')) {
    try {
      await $fetch(`/booking/${id}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      alert('Booking deleted successfully!')
      router.replace('/bookings') // Redirect to bookings list
    } catch (err) {
      console.error('Failed to delete booking:', err)
      alert('Failed to delete booking. Please try again.')
    }
  }
}
</script>

