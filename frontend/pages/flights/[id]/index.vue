<template>
  <div class="flight-details" v-if="flight">
    <NuxtLink to="/flights" class="back-link">&larr; All Flights</NuxtLink>

    <h2>Flight {{ flight.flightno }} Details</h2>

    <div class="flight-info">
      <div>
        <strong>Flight No.</strong><br />
        {{ flight.flightno }}
      </div>
      <div>
        <strong>From Airport</strong><br />
        {{ flight.from }}
      </div>
      <div>
        <strong>To Airport</strong><br />
        {{ flight.to }}
      </div>
      <div>
        <strong>Departure</strong><br />
        {{ formatDate(flight.departure) }}
      </div>
      <div>
        <strong>Arrival</strong><br />
        {{ formatDate(flight.arrival) }}
      </div>
      <div>
        <strong>Airline</strong><br />
        {{ flight.airline_id }}
      </div>
      <div>
        <strong>Airplane</strong><br />
        {{ flight.airplane_id }}
      </div>
    </div>

    <div class="button-group">
      <NuxtLink :to="`/flights/${flightId}/edit`">
        <button>Edit</button>
      </NuxtLink>
      <button class="delete" @click="onDelete">Delete</button>
    </div>

    <h3>Passengers on This Flight</h3>
    <table>
      <thead>
        <tr>
          <th>Seat</th>
          <th>Passenger</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in passengers" :key="p.id">
          <td>{{ p.seat }}</td>
          <td>{{ p.name }}</td>
          <td>{{ p.email }}</td>
          <td>{{ p.contact }}</td>
          <td><button class="view-button">View</button></td>
        </tr>
        <tr v-if="passengers.length === 0">
          <td colspan="5">No passengers for this flight.</td>
        </tr>
      </tbody>
    </table>

    <h3>Flight Logs</h3>
    <table>
      <thead>
        <tr>
          <th>Log Date</th>
          <th>Changed By</th>
          <th>Old Values</th>
          <th>New Values</th>
          <th>Comment</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Oct 19, 2023 11:30</td>
          <td>Alice Smith</td>
          <td>
            25.Aug.20 08:00<br />
            Aug 20, 10:00
          </td>
          <td>
            25.Aug.20 09:30<br />
            Aug 20, 10:30
          </td>
          <td>Updated departure time</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAsyncData, useRuntimeConfig } from '#imports'
import { useFlights } from '~/composables/useFlights'

// Params, router, config
const route    = useRoute()
const router   = useRouter()
const config   = useRuntimeConfig()
const flightId = computed(() => Number(route.params.id))

// Dynamic key so it re-fetches on each navigation
const dataKey = computed(() => `flight-${flightId.value}-${route.fullPath}`)

// Fetch flight using useAsyncData (no TS generics)
const { data: flightData, error } = await useAsyncData(
  dataKey,
  () => $fetch(`/api/flights/${flightId.value}`, {
    baseURL: config.public.apiBase,
    headers: { Accept: 'application/json' }
  }),
  {
    onError: () => {
      router.replace('/flights')
    }
  }
)

// Expose plain `flight` for template
const flight = computed(() => flightData.value)

// Passengers (static for now)
const passengers = ref([
  { id:1, seat:'12A', name:'John Doe',            email:'john@example.com',       contact:'+123 456 7890' },
  { id:2, seat:'14B', name:'Jane Smith',          email:'jane@example.com',       contact:'+987 654 3210' },
  { id:3, seat:'15C', name:'Carlos Ruiz',         email:'carlos.ruiz@example.com',contact:'+385 91 234 5678' },
  { id:4, seat:'16D', name:'Johannes Schmidt',    email:'johannessc@example.com', contact:'+387 62 112 334' }
])

// Delete via composable, then navigate home
const { deleteFlight } = useFlights()
function onDelete() {
  if (confirm('Are you sure you want to delete this flight?')) {
    deleteFlight(flightId.value)
    router.push('/flights')
  }
}

// Date formatter
function formatDate(dt) {
  return dt ? new Date(dt).toLocaleString() : ''
}
</script>

<style scoped>
.back-link {
  display: inline-block;
  margin-bottom: 20px;
  color: #0b3a66;
  text-decoration: none;
  font-weight: bold;
}

.flight-info {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  border: 1px solid #0b3a66;
  padding: 16px;
  margin-bottom: 24px;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
}

.button-group button {
  background-color: #0b3a66;
  color: white;
  border: none;
  padding: 10px 16px;
  cursor: pointer;
  font-weight: bold;
}

.button-group .delete {
  background-color: #a40000;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
}

th,
td {
  padding: 10px;
  border: 1px solid #ccc;
}

th {
  background-color: #e5eef8;
}

.view-button {
  background-color: #0b3a66;
  color: white;
  padding: 6px 12px;
  border: none;
  cursor: pointer;
}
</style>
