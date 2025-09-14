<template>
  <div class="passenger-detail-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">👤</span>
          Passenger Details
        </h1>
        <p>View passenger information and booking history</p>
      </div>
    </div>

    <div v-if="pending" class="text-center py-4">
      <div class="spinner"></div>
      <p class="text-muted mt-2">Loading passenger details...</p>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      ❌ Error loading passenger: {{ error.message }}
    </div>

    <div v-else-if="passenger" class="card">
      <div class="card-header">
        <h2 class="card-title">Passenger Information</h2>
      </div>
      <div class="card-body">
        <div class="detail-row">
          <span class="detail-label">Passport Number:</span>
          <span class="detail-value">{{ passenger.passportno }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">First Name:</span>
          <span class="detail-value">{{ passenger.firstname }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Last Name:</span>
          <span class="detail-value">{{ passenger.lastname }}</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Full Name:</span>
          <span class="detail-value">{{ passenger.firstname }} {{ passenger.lastname }}</span>
        </div>
      </div>
      <div class="card-footer form-actions">
        <NuxtLink :to="`/passengers/${passenger.passenger_id}/edit`" class="btn btn-warning">
          ✂ Edit Passenger
        </NuxtLink>
        <button @click="deletePassenger" class="btn btn-danger">
          ❌ Delete Passenger
        </button>
        <NuxtLink to="/passengers" class="btn btn-secondary">
          ← Back to Passengers
        </NuxtLink>
      </div>
    </div>

    <div v-else class="alert alert-warning">
      ⚠️ Passenger not found
    </div>
  </div>
</template>

<script setup lang="ts">
const route = useRoute()
const router = useRouter()
const config = useRuntimeConfig()

const passengerId = route.params.id

// get passenger info
const {
  data: passenger,
  pending,
  error,
  refresh
} = await useAsyncData(
  `passenger-${passengerId}`,
  () => $fetch(`/passengers/${passengerId}`, {
    baseURL: config.public.apiBase,
    headers: {
      'Authorization': `Basic ${btoa(config.public.basicAuth)}`
    }
  }),
  {
    default: () => null
  }
)

async function deletePassenger() {
  if (confirm('Are you sure you want to delete this passenger? This will also delete all their bookings.')) {
    try {
      await $fetch(`/passengers/${passengerId}`, {
        method: 'DELETE',
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Basic ${btoa(config.public.basicAuth)}`
        }
      })
      alert('Passenger deleted successfully!')
      router.push('/passengers')
    } catch (error) {
      console.error('Failed to delete passenger:', error)
      alert('Failed to delete passenger. Please try again.')
    }
  }
}
</script>

