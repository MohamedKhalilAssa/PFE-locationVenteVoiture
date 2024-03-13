<template>
  <aside
    class="-translate-x-full duration-500 ease-in-out min-h-screen min-w-52 overflow-auto w-11/12 shadow-lg sm:w-72 bg-white md:bg-gray-200 md:translate-x-0 md:shadow-none"
    :class="props.addClass">
    <div class="linksCont flex justify-center items-center h-min">
      <div class="brand h-min w-48 flex items-baseline overflow-hidden ml-6 sm:ml-0">
        <img loading="lazy" src="@/assets/images/LogoPNGCroppedR.png" alt="logo"
          class="h-full w-full object-cover block" />
      </div>
    </div>
    <div class="links px-6 pb-6 pl-12 flex flex-col items-center h-full overflow-auto md:pl-10"
      style="max-height: calc(100vh - 90px)">
      <router-link to="/admin"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-square-poll-vertical h-min w-min text-2xl"></i>
        <p>Dashboard</p>
      </router-link>
      <router-link to="/admin/users"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-user"></i>
        <p>Clients</p>
      </router-link>
      <router-link to="/admin/marques"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-industry"></i>
        <p>Marques</p>
      </router-link>
      <router-link to="/admin/modeles"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-car"></i>
        <p>Modeles</p>
      </router-link>
      <router-link to="/admin/occasion"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-car-burst"></i>
        <p>Occasions</p>
      </router-link>
      <router-link to="/admin/neuf"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-car-on"></i>
        <p>Neufs</p>
      </router-link>
      <router-link to="/admin/location"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-stopwatch"></i>
        <p>Locations</p>
      </router-link>
      <router-link to="/admin/vente"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-hand-holding-dollar"></i>
        <p>Vente</p>
      </router-link>
      <router-link to="/admin/villes"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-city"></i>
        <p>Villes</p>
      </router-link>
      <router-link to="/admin/couleurs"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
        <i class="fa-solid fa-paint-roller"></i>
        <p>Couleurs</p>
      </router-link>
    </div>
  </aside>
</template>
<script setup>
import { watchEffect } from "vue";

const props = defineProps(["addClass"]);
</script>
<style scoped>
aside {
  position: fixed;
  left: 0;
  top: 0;
}

.router-link-exact-active {
  background-color: rgb(254 202 202);
  border-left: solid 8px rgb(248 113 113);
  color: rgb(127 29 29);
}
</style>
