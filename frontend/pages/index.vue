<template>
  <div class="dashboard">
    <h1>Dashboard</h1>

    <!-- Stat cards -->
    <div class="stat-cards">
      <NuxtLink to="/flights" class="stat-card-link">
        <StatCard title="Flights" :value="flights?.length" />
      </NuxtLink>
      <StatCard title="Airplanes" value="25" />
      <StatCard title="Passengers" value="35000" />
      <StatCard title="Bookings" value="850" />
    </div>

    <!-- Quick actions -->
    <div class="quick-actions">
      <h2>Quick Actions</h2>
      <div class="button-group">
        <NuxtLink to="/flights/new"><button>Add Flight</button></NuxtLink>
        <button>Add Booking</button>
        <button>Add Passenger</button>
      </div>
    </div>

    <!-- Recent Flights -->
    <div class="recent-flights">
      <h2>Recent Flights</h2>
      <div v-if="pending">Loading...</div>
      <div v-else-if="error">Error loading flights: {{ error.message }}</div>
      <table v-else>
        <thead>
          <tr>
            <th>Flight</th>
            <th>From</th>
            <th>To</th>
            <th>Departure</th>
            <th>Arrival</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="flight in flights || []" :key="flight.flight_id">
            <td>
              <NuxtLink
                :to="`/flights/${flight.flight_id}`"
                class="flight-link"
              >
                {{ flight.flightno }}
              </NuxtLink>
            </td>
            <td>{{ flight.from }}</td>
            <td>{{ flight.to }}</td>
            <td>{{ flight.departure }}</td>
            <td>{{ flight.arrival }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'
import { computed } from 'vue'
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

// key must change on every navigation
const dataKey = computed(() => `flights-${route.fullPath}`)

const {
  data: flights,
  pending,
  error,
} = await useAsyncData<Flight[]>(
  dataKey,
  () => $fetch('/api/flights', { baseURL: config.public.apiBase })
)
</script>

<style scoped>
.dashboard {
  font-family: sans-serif;
}

.stat-cards {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
}

.quick-actions {
  border: 1px solid #0b3a66;
  padding: 16px;
  margin-bottom: 30px;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.button-group button {
  background-color: #0b3a66;
  color: white;
  border: none;
  padding: 10px 16px;
  cursor: pointer;
  font-weight: bold;
}

.button-group button:hover {
  background-color: #14589e;
}

.recent-flights table {
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #0b3a66;
}

.recent-flights th,
.recent-flights td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ccc;
}

.recent-flights th {
  background-color: #e5eef8;
}
</style>
