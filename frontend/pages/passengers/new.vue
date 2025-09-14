<template>
  <div class="new-passenger-page">
    <div class="page-header">
      <div class="page-header-content">
        <h1>
          <span class="page-header-icon">👤</span>
          Add New Passenger
        </h1>
        <p>Create a new passenger profile</p>
      </div>
    </div>

    <div class="card">
      <form @submit.prevent="submit" class="passenger-form">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Passport Number *</label>
            <input 
              v-model="form.passportno" 
              type="text" 
              class="form-control"
              placeholder="e.g., A1234567"
              required 
            />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">First Name *</label>
            <input 
              v-model="form.firstname" 
              type="text" 
              class="form-control"
              required 
            />
          </div>

          <div class="form-group">
            <label class="form-label">Last Name *</label>
            <input 
              v-model="form.lastname" 
              type="text" 
              class="form-control"
              required 
            />
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-success btn-lg">
            👤 Create Passenger
          </button>
          <button type="button" class="btn btn-secondary btn-lg" @click="cancel">
            ❌ Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { useRouter, useRuntimeConfig } from '#imports'

const router = useRouter()
const config = useRuntimeConfig()

const form = reactive({
  passportno: '',
  firstname: '',
  lastname: ''
})

// Form validation and submission

async function submit() {
  try {
    await $fetch('/passengers', {
      method: 'POST',
      baseURL: config.public.apiBase,
      headers: {
        'Authorization': `Basic ${btoa(config.public.basicAuth)}`
      },
      body: form
    })

    alert('Passenger created successfully!')
    
    router.replace('/')
  } catch (error) {
    console.error('Failed to create passenger:', error)
    alert('Failed to create passenger. Please try again.')
  }
}

function cancel() {
  router.replace('/passengers')
}
</script>

