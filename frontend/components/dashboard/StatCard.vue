<template>
  <div class="stat-card">
    <p class="label">{{ title }}</p>
    <p class="value">{{ value }}</p>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: [String, Number],
})
</script>

<style scoped>
.stat-card {
  flex: 1;
  border: 1px solid #0b3a66;
  border-radius: 4px;
  padding: 16px;
  text-align: center;
}

.label {
  font-size: 14px;
  color: #444;
}

.value {
  font-size: 24px;
  font-weight: bold;
  margin-top: 8px;
}
</style>
