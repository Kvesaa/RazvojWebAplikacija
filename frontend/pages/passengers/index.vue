<template>
  <div class="passengers-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">👥</span>
          Passengers
        </h1>
        <p>Manage passenger information and bookings</p>
      </div>
    </div>

    <!-- Search and filters -->
    <div class="card mb-4">
      <form @submit.prevent="searchPassengers" class="search-form">
        <div class="d-flex gap-3 flex-wrap">
          <div class="form-group">
            <label class="form-label">Search by name</label>
            <input 
              v-model="filters.name" 
              type="text" 
              class="form-control" 
              placeholder="Enter passenger name..."
            />
          </div>
          <div class="form-group">
            <label class="form-label">Search by passport</label>
            <input 
              v-model="filters.passport" 
              type="text" 
              class="form-control" 
              placeholder="Enter passport number..."
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
        <h2 class="card-title">👥 All Passengers ({{ filteredPassengers.length }})</h2>
        <div class="d-flex gap-2">
          <button @click="refreshData" class="btn btn-info btn-sm" :disabled="pending">
            <span v-if="pending" class="spinner"></span>
            {{ pending ? 'Loading...' : '🔄 Refresh' }}
          </button>
          <NuxtLink to="/passengers/new" class="btn btn-success">
            👤 Add New Passenger
          </NuxtLink>
        </div>
      </div>

      <div v-if="pending" class="text-center py-4">
        <div class="spinner"></div>
        <p class="text-muted mt-2">Loading passengers...</p>
      </div>

      <div v-else-if="error" class="alert alert-danger">
        ❌ Error loading passengers: {{ error.message }}
      </div>

      <div v-else class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Passport No.</th>
              <th>Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="passenger in filteredPassengers" :key="passenger.passenger_id">
              <td>
                <NuxtLink :to="`/passengers/${passenger.passenger_id}`" class="nav-link">
                  <strong>{{ passenger.passportno }}</strong>
                </NuxtLink>
              </td>
              <td>{{ passenger.firstname }} {{ passenger.lastname }}</td>
              <td>
                <div class="d-flex gap-1">
                  <NuxtLink :to="`/passengers/${passenger.passenger_id}`" class="btn btn-info btn-sm">
                    <span class="icon">ℹ</span>
                  </NuxtLink>
                  <NuxtLink :to="`/passengers/${passenger.passenger_id}/edit`" class="btn btn-warning btn-sm">
                    <span class="icon">✂</span>
                  </NuxtLink>
                  <button @click="deletePassenger(passenger.passenger_id)" class="btn btn-danger btn-sm">
                    <span class="icon">❌</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="!passengers || passengers.length === 0">
              <td colspan="3" class="text-center text-muted py-4">
                No passengers found. <NuxtLink to="/passengers/new" class="btn btn-primary btn-sm">Add your first passenger</NuxtLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { useRouter, useRoute, useRuntimeConfig } from '#imports'

const router = useRouter()
const route = useRoute()
const config = useRuntimeConfig()

// get passengers from api
const {
  data: passengers,
  pending,
  error,
  refresh
} = await useAsyncData(
  'passengers',
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
  name: '',
  passport: ''
})

// Filtered passengers based on search criteria
const filteredPassengers = computed(() => {
  if (!passengers.value) return []
  
  return passengers.value.filter(p => {
    const nameMatch = !filters.name || 
      `${p.firstname} ${p.lastname}`.toLowerCase().includes(filters.name.toLowerCase())
    const passportMatch = !filters.passport || 
      p.passportno.toLowerCase().includes(filters.passport.toLowerCase())
    
    return nameMatch && passportMatch
  })
})

function searchPassengers() {
  // Search functionality is handled by computed filteredPassengers
}

// Add refresh function for the refresh button
function refreshData() {
  refresh()
}

async function deletePassenger(passengerId) {
  if (confirm('Are you sure you want to delete this passenger?')) {
    try {
      await $fetch(`/passengers/${passengerId}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      
      // Refresh the passengers list
      await refresh()
      alert('Passenger deleted successfully!')
    } catch (error) {
      console.error('Failed to delete passenger:', error)
      alert('Failed to delete passenger. Please try again.')
    }
  }
}

function formatDate(dateString) {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

