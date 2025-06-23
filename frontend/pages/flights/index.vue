<template>
  <div class="flights-page">
    <div class="page-header">
      <h1>Flights</h1>
      <NuxtLink to="/flights/new" class="add-button">Add New Flight</NuxtLink>
    </div>

    <form class="search-form" @submit.prevent="searchFlights">
      <input type="text" v-model="filters.flight" placeholder="Flight" />
      <input type="text" v-model="filters.from" placeholder="From" />
      <input type="text" v-model="filters.to" placeholder="To" />
      <input type="text" v-model="filters.departure" placeholder="Departure" />
      <input type="text" v-model="filters.arrival" placeholder="Arrival" />
      <button type="submit" class="search-button">Search</button>
    </form>

    <div v-if="pending">Loading...</div>
    <div v-else-if="error">Error loading flights: {{ error.message }}</div>
    <table v-else class="flights-table">
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
            <NuxtLink :to="`/flights/${flight.flight_id}`" class="flight-link">
              {{ flight.flightno }}
            </NuxtLink>
          </td>
          <td>{{ flight.from }}</td>
          <td>{{ flight.to }}</td>
          <td>{{ flight.departure }}</td>
          <td>{{ flight.arrival }}</td>
          <td><button class="view-button">View</button></td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <span>Previous</span>
      <span class="page-number">1</span>
      <span>Next</span>
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

const {
  data: flights,
  pending,
  error,
} = await useAsyncData<Flight[]>(
  dataKey,
  () => $fetch('/api/flights', { baseURL: config.public.apiBase })
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

function searchFlights() {
}
</script>

<style scoped>
.flights-page {
  font-family: sans-serif;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.add-button {
  background-color: #0b3a66;
  color: white;
  border: none;
  padding: 10px 16px;
  font-weight: bold;
  cursor: pointer;
}

.search-form {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.search-form input {
  padding: 8px;
  border: 1px solid #ccc;
  flex: 1;
  min-width: 100px;
}

.search-button {
  background-color: #0b3a66;
  color: white;
  border: none;
  padding: 8px 16px;
  font-weight: bold;
  cursor: pointer;
}

.flights-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 16px;
  border: 1px solid #0b3a66;
}

.flights-table th,
.flights-table td {
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.flights-table th {
  background-color: #e5eef8;
}

.view-button {
  background-color: #0b3a66;
  color: white;
  border: none;
  padding: 6px 12px;
  cursor: pointer;
  font-weight: bold;
}

.pagination {
  display: flex;
  justify-content: flex-end;
  gap: 8px;
  color: #444;
}

.page-number {
  font-weight: bold;
  padding: 0 6px;
}
</style>
