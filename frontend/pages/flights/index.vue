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

    <table class="flights-table">
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
import { reactive, computed } from "vue";
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

const config = useRuntimeConfig()

const { data: flights, pending, error } = await useFetch<Flight[]>('/api/flights', {
  baseURL: config.public.apiBase,
})

const filters = reactive({
  flight: '',
  from: '',
  to: '',
  departure: '',
  arrival: '',
})

const filteredFlights = computed(() => {
  return (flights.value || []).filter((flight) =>
    (!filters.flight || flight.flightno.toLowerCase().includes(filters.flight.toLowerCase())) &&
    (!filters.from || String(flight.from).includes(filters.from)) &&
    (!filters.to || String(flight.to).includes(filters.to)) &&
    (!filters.departure || flight.departure.includes(filters.departure)) &&
    (!filters.arrival || flight.arrival.includes(filters.arrival))
  )
})

function searchFlights() {
  // Optional
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
