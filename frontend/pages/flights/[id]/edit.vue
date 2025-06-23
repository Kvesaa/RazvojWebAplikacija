<template>
  <div class="form-page">
    <h1>Edit Flight</h1>
    <form @submit.prevent="submit">
      <label>
        Flight No.:
        <input v-model="form.flightno" required />
      </label>

      <label>
        From:
        <input v-model.number="form.from" required />
      </label>

      <label>
        To:
        <input v-model.number="form.to" required />
      </label>

      <label>
        Departure:
        <input v-model="form.departure" type="datetime-local" required />
      </label>

      <label>
        Arrival:
        <input v-model="form.arrival" type="datetime-local" required />
      </label>

      <label>
        Airline:
        <input v-model.number="form.airline_id" required />
      </label>

      <label>
        Airplane:
        <input v-model.number="form.airplane_id" required />
      </label>

      <button type="submit">Save Changes</button>
    </form>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { reactive } from 'vue'
import { useFetch, useRuntimeConfig } from '#imports'

const route    = useRoute()
const router   = useRouter()
const config   = useRuntimeConfig()
const flightId = Number(route.params.id)

// 1) fetch flight, redirect on error
const { data: flight } = await useFetch(
  `/api/flights/${flightId}`,
  {
    baseURL: config.public.apiBase,
    onError: () => {
      router.replace('/flights')
    }
  }
)

// 2) seed reactive form
const form = reactive({
  flightno:   flight.value.flightno,
  from:       flight.value.from,
  to:         flight.value.to,
  departure:  flight.value.departure,
  arrival:    flight.value.arrival,
  airline_id: flight.value.airline_id,
  airplane_id:flight.value.airplane_id
})

// 3) on submit, PUT and navigate back to details
async function submit() {
  await $fetch(`/api/flights/${flightId}`, {
    method: 'PUT',
    baseURL: config.public.apiBase,
    body: form
  })
  router.push(`/flights/${flightId}`)
}
</script>

<style scoped>
.form-page {
  max-width: 500px;
  margin: auto;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
label {
  display: flex;
  flex-direction: column;
}
button {
  background-color: #0b3a66;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
}
</style>
