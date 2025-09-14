<template>
  <div class="edit-flight-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">✏️</span>
          Edit Flight
        </h1>
        <p>Update flight details</p>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="card-title">📝 Flight Details</h2>
      </div>
      
      <form @submit.prevent="submit">
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">Flight Number *</label>
            <input 
              v-model="form.flightno" 
              class="form-control"
              placeholder="e.g., AA123"
              required 
            />
          </div>

          <div class="form-group">
            <label class="form-label">From Airport *</label>
            <select v-model.number="form.from" class="form-control" required>
              <option value="">Select departure airport</option>
              <option v-for="airport in airports" :key="airport.id" :value="airport.id">
                {{ airport.code }} - {{ airport.name }} ({{ airport.city }})
              </option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">To Airport *</label>
            <select v-model.number="form.to" class="form-control" required>
              <option value="">Select arrival airport</option>
              <option v-for="airport in airports" :key="airport.id" :value="airport.id">
                {{ airport.code }} - {{ airport.name }} ({{ airport.city }})
              </option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Departure Time *</label>
            <input 
              v-model="form.departure" 
              type="datetime-local" 
              class="form-control"
              :min="minDepartureDate"
              required 
            />
          </div>

          <div class="form-group">
            <label class="form-label">Arrival Time *</label>
            <input 
              v-model="form.arrival" 
              type="datetime-local" 
              class="form-control"
              :min="minArrivalDate"
              required 
            />
          </div>

          <div class="form-group">
            <label class="form-label">Airline *</label>
            <select v-model.number="form.airline_id" class="form-control" required>
              <option value="">Select airline</option>
              <option v-for="airline in airlines" :key="airline.id" :value="airline.id">
                {{ airline.code }} - {{ airline.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Airplane *</label>
            <select v-model.number="form.airplane_id" class="form-control" required>
              <option value="">Select airplane</option>
              <option v-for="airplane in airplanes" :key="airplane.id" :value="airplane.id">
                {{ airplane.registration }} - {{ airplane.type }} ({{ airplane.capacity }} seats)
              </option>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-success btn-lg">
            💾 Save Changes
          </button>
          <button type="button" class="btn btn-secondary btn-lg" @click="cancel">
            ❌ Cancel
          </button>
          <button type="button" class="btn btn-danger btn-lg" @click="deleteFlight">
            🗑️ Delete Flight
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import { useRouter, useRoute, useRuntimeConfig } from '#imports'

const router = useRouter()
const route = useRoute()
const config = useRuntimeConfig()

const form = reactive({
  flightno:   '',
  from:        0,
  to:          0,
  departure:  '',
  arrival:    '',
  airline_id:  0,
  airplane_id: 0
})

// dropdown options
const airports = ref([
  { id: 1, code: 'JFK', name: 'John F. Kennedy International', city: 'New York' },
  { id: 2, code: 'LAX', name: 'Los Angeles International', city: 'Los Angeles' },
  { id: 3, code: 'LHR', name: 'London Heathrow', city: 'London' },
  { id: 4, code: 'CDG', name: 'Charles de Gaulle', city: 'Paris' },
  { id: 5, code: 'FRA', name: 'Frankfurt Airport', city: 'Frankfurt' },
  { id: 6, code: 'NRT', name: 'Narita International', city: 'Tokyo' },
  { id: 7, code: 'SYD', name: 'Sydney Kingsford Smith', city: 'Sydney' },
  { id: 8, code: 'DXB', name: 'Dubai International', city: 'Dubai' },
  { id: 9, code: 'SIN', name: 'Singapore Changi', city: 'Singapore' },
  { id: 10, code: 'ICN', name: 'Incheon International', city: 'Seoul' }
])

const airlines = ref([
  { id: 1, code: 'AA', name: 'American Airlines' },
  { id: 2, code: 'BA', name: 'British Airways' },
  { id: 3, code: 'LH', name: 'Lufthansa' },
  { id: 4, code: 'AF', name: 'Air France' },
  { id: 5, code: 'JL', name: 'Japan Airlines' },
  { id: 6, code: 'QF', name: 'Qantas' },
  { id: 7, code: 'EK', name: 'Emirates' },
  { id: 8, code: 'SQ', name: 'Singapore Airlines' },
  { id: 9, code: 'KE', name: 'Korean Air' },
  { id: 10, code: 'DL', name: 'Delta Air Lines' }
])

const airplanes = ref([
  { id: 1, registration: 'N123AA', type: 'Boeing 737-800', capacity: 162 },
  { id: 2, registration: 'N456BB', type: 'Airbus A320', capacity: 150 },
  { id: 3, registration: 'N789CC', type: 'Boeing 777-300ER', capacity: 396 },
  { id: 4, registration: 'N321DD', type: 'Airbus A350-900', capacity: 315 },
  { id: 5, registration: 'N654EE', type: 'Boeing 787-9 Dreamliner', capacity: 290 },
  { id: 6, registration: 'N987FF', type: 'Airbus A380-800', capacity: 525 },
  { id: 7, registration: 'N147GG', type: 'Boeing 747-8', capacity: 467 },
  { id: 8, registration: 'N258HH', type: 'Airbus A330-300', capacity: 277 },
  { id: 9, registration: 'N369II', type: 'Boeing 737 MAX 8', capacity: 178 },
  { id: 10, registration: 'N741JJ', type: 'Airbus A321neo', capacity: 194 }
])

// Computed properties for date validation
const minDepartureDate = computed(() => {
  return new Date().toISOString().slice(0, 16)
})

const minArrivalDate = computed(() => {
  if (!form.departure) return new Date().toISOString().slice(0, 16)
  return form.departure
})

onMounted(() => {
  // load flight info
  const flightId = route.params.id
  form.flightno = 'AA123'
  form.from = 1  // JFK
  form.to = 3    // LHR
  form.departure = '2023-10-20T09:00'
  form.arrival = '2023-10-20T12:30'
  form.airline_id = 1  // American Airlines
  form.airplane_id = 1 // Boeing 737-800
})

async function submit() {
  try {
    const payload = {
      flightno: form.flightno,
      from: form.from,
      to: form.to,
      departure: form.departure.replace('T', ' ') + ':00',
      arrival: form.arrival.replace('T', ' ') + ':00',
      airline_id: form.airline_id,
      airplane_id: form.airplane_id
    }

    await $fetch(`/flights/${route.params.id}`, {
      method: 'PUT',
      baseURL: config.public.apiBase,
      headers: {
        'Authorization': `Basic ${btoa(config.public.basicAuth)}`
      },
      body: payload
    })

    alert('Flight updated successfully!')
    
    router.replace('/flights')
  } catch (error) {
    console.error('Failed to update flight:', error)
    alert('Failed to update flight. Please try again.')
  }
}

function cancel() {
  router.replace('/flights')
}

function deleteFlight() {
  if (confirm('Are you sure you want to delete this flight? This action cannot be undone.')) {
    // delete not working yet
    router.replace('/flights')
  }
}
</script>
