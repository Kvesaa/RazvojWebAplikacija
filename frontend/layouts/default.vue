<template>
  <div>
    <Sidebar />
    <main class="page-content">
      <slot />
    </main>
  </div>
</template>

<script setup>
import Sidebar from '~/layouts/Sidebar.vue'
</script>

<style scoped>
.page-content {
  margin-left: 240px;
  padding: 24px;
  min-height: 100vh;
  background-color: #f4f7fa;
}
</style>