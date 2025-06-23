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

<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router'
import { reactive, computed, watchEffect } from 'vue'
import { useAsyncData, useRuntimeConfig } from '#imports'

const route    = useRoute()
const router   = useRouter()
const config   = useRuntimeConfig()

// 1) Dynamic flightId + key for AsyncData
const flightId = computed(() => Number(route.params.id))
const dataKey  = computed(() => `flight-${flightId.value}`)

// 2) Fetch via useAsyncData (auto re-runs when dataKey changes)
const { data: flight, error } = await useAsyncData(
  dataKey,
  () => $fetch(`/api/flights/${flightId.value}`, {
    baseURL: config.public.apiBase
  }),
  
)

// 3) Seed reactive form when flight arrives
const form = reactive({
  flightno:   '',
  from:        0,
  to:          0,
  departure:  '',
  arrival:    '',
  airline_id:  0,
  airplane_id: 0
})

watchEffect(() => {
  if (!flight.value) return
  form.flightno    = flight.value.flightno
  form.from        = flight.value.from
  form.to          = flight.value.to
  form.departure   = flight.value.departure
  form.arrival     = flight.value.arrival
  form.airline_id  = flight.value.airline_id
  form.airplane_id = flight.value.airplane_id
})

// 4) Submit: PUT back and navigate
async function submit() {
  await $fetch(`/api/flights/${flightId.value}`, {
    method: 'PUT',
    baseURL: config.public.apiBase,
    body: { ...form }
  })
  router.push(`/flights/${flightId.value}`)
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
