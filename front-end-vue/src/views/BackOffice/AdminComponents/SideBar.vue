<template>
  <aside class="fixed top-0 left-0 -translate-x-3/4 h-full bg-gray-950 w-72 shadow-sm flex flex-col"
    :class="props.addClass" style="background-color: #333;">
    <div class="burgerContainer flex justify-end w-full h-max p-4 pr-5 mb-12">
      <div id="menuToggle" class="block pt-1" @click="toggleMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="navIcons flex justify-end w-full overflow-auto">
      <div class="links min-w-full pb-6 flex flex-col justify-start items-end h-full overflow-auto">
        <router-link v-for="link in links" :to="{ name: link.to }"
          class="adminLink text-gray-300 p-2 w-12 mx-4 my-3 flex justify-center items-center hover:font-bold duration-100">
          <i class="fa-solid h-min w-min text-2xl" :class="'fa-' + link.icon"></i>
        </router-link>
      </div>
    </div>
  </aside>
  <!-- <div class="links px-6 pb-6 pl-12 flex flex-col items-center h-full overflow-auto md:pl-10"
    style="max-height: calc(100vh - 90px)">
    <router-link :to="{ name: 'adminHome' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-square-poll-vertical h-min w-min text-2xl"></i>
      <p>Dashboard</p>
    </router-link>
    <router-link :to="{ name: 'usersView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-user"></i>
      <p>Utilisateurs</p>
    </router-link>
    <router-link :to="{ name: 'marquesView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-industry"></i>
      <p>Marques</p>
    </router-link>
    <router-link :to="{ name: 'modelesView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-car"></i>
      <p>Modeles</p>
    </router-link>
    <router-link :to="{ name: 'occasionView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-car-burst"></i>
      <p>Occasions</p>
    </router-link>
    <router-link to="/admin/neuf" :to="{ name: 'neufView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-car-on"></i>
      <p>Neufs</p>
    </router-link>
    <router-link to="/admin/location" :to="{ name: 'locationView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-stopwatch"></i>
      <p>Locations</p>
    </router-link>
    <router-link :to="{ name: 'venteView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-hand-holding-dollar"></i>
      <p>Vente</p>
    </router-link>
    <router-link :to="{ name: 'villesView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-city"></i>
      <p>Villes</p>
    </router-link>
    <router-link :to="{ name: 'couleursView' }"
      class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100">
      <i class="fa-solid fa-paint-roller"></i>
      <p>Couleurs</p>
    </router-link> -->
  <!-- </div> -->
</template>
<script setup>
import Logo from "@/Components/Logo.vue";

const props = defineProps(["addClass"]);

const links = [
  { nom: 'Dashboard', icon: 'square-poll-vertical', to: 'adminHome' },
  { nom: 'Utilisateurs', icon: 'user', to: 'usersView' },
  { nom: 'Marques', icon: 'industry', to: 'marquesView' },
  { nom: 'Modeles', icon: 'car', to: 'modelesView' },
  { nom: 'Occasions', icon: 'car-burst', to: 'occasionView' },
  { nom: 'Neufs', icon: 'car-on', to: 'neufView' },
  { nom: 'Locations', icon: 'stopwatch', to: 'locationView' },
  { nom: 'Vente', icon: 'hand-holding-dollar', to: 'venteView' },
  { nom: 'Villes', icon: 'city', to: 'villesView' },
  { nom: 'Couleurs', icon: 'paint-roller', to: 'couleursView' },
]


</script>
<!-- <style scoped>
.router-link-exact-active {
  background-color: rgb(254 202 202);
  border-left: solid 8px rgb(248 113 113);
  color: rgb(127 29 29);
}
</style> -->
<style scoped src="@/assets/css/AdminNavbar.css"></style>
