<template>
  <div class="form-page">
    <h1>Add Flight</h1>
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

      <div class="button-row">
        <button type="submit">Add Flight</button>
        <button type="button" class="cancel" @click="cancel">Cancel</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter, useRuntimeConfig } from '#imports'

const router = useRouter()
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

async function submit() {
  const payload = {
    flightno:   form.flightno,
    from:       form.from,
    to:         form.to,
    departure:  form.departure.replace('T', ' ') + ':00',
    arrival:    form.arrival.replace('T', ' ') + ':00',
    airline_id: form.airline_id,
    airplane_id: form.airplane_id
  }

  await $fetch('/api/flights', {
    method: 'POST',
    baseURL: config.public.apiBase,
    body: payload
  })

  router.replace('/flights')
}

function cancel() {
  router.replace('/flights')
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

.button-row {
  display: flex;
  gap: 1rem;
}

button {
  background-color: #0b3a66;
  color: white;
  padding: 10px 16px;
  border: none;
  cursor: pointer;
}

button.cancel {
  background-color: #aaa;
}
</style>
