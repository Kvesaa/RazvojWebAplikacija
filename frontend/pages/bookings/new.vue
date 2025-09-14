<template>
  <div class="new-booking-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">📋</span>
          Add New Booking
        </h1>
        <p>Create a new flight booking</p>
      </div>
    </div>

    <div class="card">
      <form @submit.prevent="submit" class="booking-form">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Passenger *</label>
            <select v-model.number="form.passenger_id" class="form-control" required>
              <option value="">Select passenger</option>
              <option v-for="passenger in passengers" :key="passenger.passenger_id" :value="passenger.passenger_id">
                {{ passenger.firstname }} {{ passenger.lastname }} ({{ passenger.email }})
              </option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Flight *</label>
            <select v-model.number="form.flight_id" class="form-control" required>
              <option value="">Select flight</option>
              <option v-for="flight in flights" :key="flight.flight_id" :value="flight.flight_id">
                {{ flight.flightno }} - {{ flight.from_airport }} to {{ flight.to_airport }}
              </option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Seat Number *</label>
            <input 
              v-model="form.seat" 
              type="text" 
              class="form-control"
              placeholder="e.g., 12A, 15C"
              required 
            />
          </div>

          <div class="form-group">
            <label class="form-label">Price *</label>
            <input 
              v-model.number="form.price" 
              type="number" 
              step="0.01"
              class="form-control"
              placeholder="0.00"
              required
            />
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-success btn-lg">
            📋 Create Booking
          </button>
          <button type="button" class="btn btn-secondary btn-lg" @click="cancel">
            ❌ Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { useRouter, useRuntimeConfig } from '#imports'

const router = useRouter()
const config = useRuntimeConfig()

const form = reactive({
  passenger_id: 0,
  flight_id: 0,
  seat: '',
  price: 0
})

// get passengers
const { data: passengers } = await useAsyncData(
  'booking-passengers',
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

// get flights
const { data: flights } = await useAsyncData(
  'booking-flights',
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

// Form submission

async function submit() {
  try {
    await $fetch('/booking', {
      method: 'POST',
      baseURL: config.public.apiBase,
      headers: {
        'Authorization': `Basic ${btoa(config.public.basicAuth)}`
      },
      body: form
    })

    alert('Booking created successfully!')
    
    router.replace('/')
  } catch (error) {
    console.error('Failed to create booking:', error)
    alert('Failed to create booking. Please try again.')
  }
}

function cancel() {
  router.replace('/bookings')
}
</script>

