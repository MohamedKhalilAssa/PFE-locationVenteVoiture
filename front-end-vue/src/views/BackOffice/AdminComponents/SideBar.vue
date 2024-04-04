<template>
  <aside
    class="-translate-x-full duration-500 ease-in-out min-h-screen min-w-52 overflow-auto w-11/12 shadow-lg sm:w-72 bg-white md:bg-gray-200 md:translate-x-0 md:shadow-none"
    :class="props.addClass"
  >
    <div class="linksCont flex justify-center items-center h-min mb-12 md:mb-0">
      <Logo imageSrc="/assets/images/LogoPNGCroppedR.png" toName="home" />
    </div>
    <div
      class="links px-6 pb-6 pl-12 flex flex-col items-center h-full overflow-auto md:pl-10"
      style="max-height: calc(100vh - 90px)"
    >
      <router-link
        :to="{ name: 'adminHome' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-square-poll-vertical h-min w-min text-2xl"></i>
        <p>Dashboard</p>
      </router-link>
      <router-link
        :to="{ name: 'usersView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-user"></i>
        <p>Utilisateurs</p>
      </router-link>
      <router-link
        :to="{ name: 'marquesView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-industry"></i>
        <p>Marques</p>
      </router-link>
      <router-link
        :to="{ name: 'modelesView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-car"></i>
        <p>Modeles</p>
      </router-link>
      <router-link
        :to="{ name: 'occasionView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-car-burst"></i>
        <p>Occasions</p>
      </router-link>
      <router-link
        to="/admin/neuf"
        :to="{ name: 'neufView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-car-on"></i>
        <p>Neufs</p>
      </router-link>
      <router-link
        to="/admin/location"
        :to="{ name: 'locationView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-stopwatch"></i>
        <p>Locations</p>
      </router-link>
      <router-link
        :to="{ name: 'venteView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-hand-holding-dollar"></i>
        <p>Vente</p>
      </router-link>
      <router-link
        :to="{ name: 'villesView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-city"></i>
        <p>Villes</p>
      </router-link>
      <router-link
        :to="{ name: 'couleursView' }"
        class="adminLink text-gray-500 p-4 w-full flex items-center space-x-3 hover:font-bold duration-100"
      >
        <i class="fa-solid fa-paint-roller"></i>
        <p>Couleurs</p>
      </router-link>
    </div>
  </aside>
</template>
<script setup>
import Logo from "@/Components/Logo.vue";

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
