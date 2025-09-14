<template>
  <aside class="sidebar">
    <div class="logo">
      <img src="~/assets/aeroadmin.png" alt="AeroAdmin" class="logo-image" />
    </div>
    <nav class="menu">
      <ul>
        <li><NuxtLink to="/">Dashboard</NuxtLink></li>
        <li><NuxtLink to="/flights">Flights</NuxtLink></li>
        <li><NuxtLink to="/passengers">Passengers</NuxtLink></li>
        <li><NuxtLink to="/bookings">Bookings</NuxtLink></li>
      </ul>
    </nav>
  </aside>
</template>


<script setup>
</script>

<style scoped>
.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  width: 240px;
  height: 100vh;
  background-color: #0b3a66;
  color: white;
  display: flex;
  flex-direction: column;
  font-family: sans-serif;
}

.logo {
  padding: 15px;
  background-color: #0a2f56;
  text-align: center;
  border-bottom: 1px solid #093456;
  display: flex;
  justify-content: center;
  align-items: center;
}

.logo-image {
  max-width: 100%;
  max-height: 60px;
  width: auto;
  height: auto;
  object-fit: contain;
}

.menu ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu li {
  border-bottom: 1px solid #093456;
}

.menu li a {
  color: white !important;
  text-decoration: none !important;
  display: block;
  padding: 20px 24px;
  transition: all 0.2s ease;
  font-weight: 500;
  border-radius: 0 !important;
}

.menu li a:hover {
  background-color: #14589e !important;
  padding-left: 32px;
  transform: translateX(4px);
  color: white !important;
}

.menu li a.router-link-active,
.menu li a.router-link-exact-active {
  background-color: #14589e !important;
  border-right: 3px solid #fff;
  font-weight: 600;
  color: white !important;
}
</style>
