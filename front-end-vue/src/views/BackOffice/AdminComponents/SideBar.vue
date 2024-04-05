<template>
  <aside
    class="fixed top-0 left-0 h-full transition-all duration-300 ease-in-out bg-gray-950 w-72 shadow-sm flex flex-col"
    :class="{ 'md:!-translate-x-3/4': !sidebarOpen }"
    style="background-color: #333"
    id="sidebar"
  >
    <div class="burgerContainer flex justify-end w-full h-max p-4 pr-5 mb-12">
      <div
        id="menuToggle"
        class="block pt-1"
        :class="{ active: sidebarOpen }"
        @click="sidebarOpen = !sidebarOpen"
      >
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="navIcons flex justify-end w-full overflow-auto">
      <div
        class="links min-w-full pr-1 pb-6 flex flex-col justify-start items-end h-full overflow-y-auto overflow-x-hidden"
      >
        <router-link
          v-for="link in links"
          :to="{ name: link.to }"
          class="adminLink w-full text-gray-300 hover:font-bold transition-all duration-300 ease-in-out flex items-baseline"
          :class="{ 'md:translate-x-3/4': !sidebarOpen }"
        >
          <i
            class="fa-solid h-min text-2xl p-2 w-12 mx-4 my-3 flex justify-center items-center hover:scale-110 duration-100"
            :class="'fa-' + link.icon"
          ></i>
          <p class="duration-0">{{ link.nom }}</p>
        </router-link>
      </div>
    </div>
  </aside>
</template>
<script setup>
import { ref } from "vue";

const sidebarOpen = ref(false); // Sidebar open

const links = [
  { nom: "Dashboard", icon: "square-poll-vertical", to: "adminHome" },
  { nom: "Utilisateurs", icon: "user", to: "usersView" },
  { nom: "Marques", icon: "industry", to: "marquesView" },
  { nom: "Modeles", icon: "car", to: "modelesView" },
  { nom: "Occasions", icon: "car-burst", to: "occasionView" },
  { nom: "Neufs", icon: "car-on", to: "neufView" },
  { nom: "Locations", icon: "stopwatch", to: "locationView" },
  { nom: "Vente", icon: "hand-holding-dollar", to: "venteView" },
  { nom: "Villes", icon: "city", to: "villesView" },
  { nom: "Couleurs", icon: "paint-roller", to: "couleursView" },
];
</script>
<style  src="@/assets/css/AdminNavbar.css"></style>
