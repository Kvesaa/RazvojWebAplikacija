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
        <input v-model="form.from" required />
      </label>

      <label>
        To:
        <input v-model="form.to" required />
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
        <input v-model="form.airline_id" required />
      </label>

      <label>
        Airplane:
        <input v-model="form.airplane_id" required />
      </label>

      <button type="submit">Add Flight</button>
    </form>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useFlights } from "~/composables/useFlights";

const router = useRouter();
const { addFlight } = useFlights();

const form = reactive({
  flightno: '',
  from: '',
  to: '',
  departure: '',
  arrival: '',
  airline_id: '',
  airplane_id: ''
})

function submit() {
  const flight = {
    ...form,
    from: Number(form.from),
    to: Number(form.to),
    airline_id: Number(form.airline_id),
    airplane_id: Number(form.airplane_id),
    departure: form.departure.replace('T', ' ') + ':00',
    arrival: form.arrival.replace('T', ' ') + ':00'
  }

  addFlight(flight)
  router.push('/flights')
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
