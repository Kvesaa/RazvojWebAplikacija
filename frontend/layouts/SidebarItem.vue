<template>
  <li>
    <NuxtLink
      :to="to"
      class="flex items-center gap-3 px-6 py-3 hover:bg-blue-800 transition-colors"
      active-class="bg-blue-800"
    >
      <i :class="`mdi ${icon} text-xl`" />
      <span class="text-sm font-medium">{{ label }}</span>
    </NuxtLink>
  </li>
</template>

<script setup>
defineProps({
  icon: String,
  label: String,
  to: String,
});
</script>
