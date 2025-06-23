<template>
  <aside class="sidebar">
    <div class="logo"><img :src="logoUrl" alt="AeroAdmin logo" class="logo-img" /></div>
    <nav class="menu">
      <ul>
        <li><NuxtLink to="/">Dashboard</NuxtLink></li>
        <li><NuxtLink to="/flights">Flights</NuxtLink></li>
        <!-- <li><NuxtLink to="/bookings">Bookings</NuxtLink></li>
        <li><NuxtLink to="/passengers">Passengers</NuxtLink></li>
        <li><NuxtLink to="/employees">Employees</NuxtLink></li>
        <li><NuxtLink to="/airplanes">Airplanes</NuxtLink></li>
        <li><NuxtLink to="/airlines">Airlines</NuxtLink></li>
        <li><NuxtLink to="/airports">Airports</NuxtLink></li>
        <li><NuxtLink to="/schedule">Flight Schedule</NuxtLink></li>
        <li><NuxtLink to="/weather">Weather</NuxtLink></li>
        <li><NuxtLink to="/logs">Logs</NuxtLink></li> -->
      </ul>
    </nav>
  </aside>
</template>


<script setup>
import logoUrl from '~/assets/aeroadmin.png'
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
  padding: 20px;
  font-size: 20px;
  font-weight: bold;
  background-color: #0a2f56;
  text-align: center;
  border-bottom: 1px solid #093456;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.logo-img {
  width: 48px;
  height: auto;
}

.menu ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu li {
  padding: 16px 20px;
  border-bottom: 1px solid #093456;
}

.menu li a {
  color: white;
  text-decoration: none;
  display: block;
}

.menu li a:hover {
  background-color: #14589e;
}
</style>
