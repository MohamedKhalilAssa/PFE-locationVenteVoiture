<template>
  <aside
    class="fixed top-0 left-0 -translate-x-3/4 transition-all duration-300 h-full bg-gray-950 w-72 shadow-sm flex flex-col"
    style="background-color: #333;" id="sidebar">
    <div class="burgerContainer flex justify-end w-full h-max p-4 pr-5 mb-12">
      <div id="menuToggle" class="block pt-1" @click="toggleMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="navIcons flex justify-end w-full overflow-auto">
      <div
        class="links min-w-full pr-1 pb-6 flex flex-col justify-start items-end h-full overflow-y-auto overflow-x-hidden">
        <router-link v-for="link in links" :to="{ name: link.to }"
          class="adminLink w-full text-gray-300 hover:font-bold transition-all duration-300 ease-in-out flex items-baseline translate-x-3/4 ">
          <i class="fa-solid h-min text-2xl p-2 w-12 mx-4 my-3 flex justify-center items-center hover:scale-110 duration-100"
            :class="'fa-' + link.icon"></i>
          <p>{{ link.nom }}</p>
        </router-link>
      </div>
    </div>
  </aside>

</template>
<script setup>
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


const toggleMenu = () => {
  document.querySelector("#menuToggle").classList.toggle("active");
  document.getElementById("sidebar").classList.toggle("-translate-x-3/4");
  document.querySelectorAll(".adminLink").forEach((element) => {
    element.classList.toggle("translate-x-3/4");
  })
};
</script>
<style scoped src="@/assets/css/AdminNavbar.css"></style>
