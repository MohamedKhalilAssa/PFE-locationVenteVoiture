<template>
  <nav
    class="bg-white border border-gray-200 px-2 py-2 rounded shadow-lg flex justify-between items-center w-full h-20 sticky top-0 z-40 lg:px-8">

    <Logo imageSrc="/assets/images/LogoPNGCroppedR.png" toName="home" />
    <div class="links hidden space-x-4 lg:flex">
      <router-link class="link hover:font-bold duration-100" to="/">Home</router-link>
      <router-link class="link hover:font-bold duration-100" to="/neuf">Neuf</router-link>
      <router-link class="link hover:font-bold duration-100" to="/occasion">Occasion</router-link>
      <router-link class="link hover:font-bold duration-100" to="/location">Location</router-link>
      <router-link class="link hover:font-bold duration-100" to="/admin" v-if="computedRole">Dashboard</router-link>
    </div>
    <div class="btns hidden lg:hidden" :class="{ blockImportant: !isAnnonce }">
      <router-link to="/annonce">
        <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-700">
          Ajouter une annonce
        </button>
      </router-link>
    </div>
    <div id="menuToggle" class="block lg:hidden" @click="toggleMenu">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </nav>
  <div
    class="linksMenu flex flex-col items-center space-y-5 py-6 fixed left-0 top-20 w-full h-screen z-100 bg-white lg:hidden">
    <router-link class="linkMob max-w-min hover:font-bold duration-100" @click="toggleMenu" to="/">Home</router-link>
    <router-link class="linkMob max-w-min hover:font-bold duration-100" @click="toggleMenu"
      to="/neuf">Neuf</router-link>
    <router-link class="linkMob max-w-min hover:font-bold duration-100" @click="toggleMenu"
      to="/occasion">Occasion</router-link>
    <router-link class="linkMob max-w-min hover:font-bold duration-100" @click="toggleMenu"
      to="/location">Location</router-link>
    <router-link class="linkMob max-w-min hover:font-bold duration-100" to="/admin"
      v-if="computedRole">Dashboard</router-link>
    <div class="btns" :class="{ hidden: isAnnonce }">
      <router-link to="/annonce">
        <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-700">
          Ajouter une annonce
        </button>
      </router-link>
    </div>
  </div>
</template>
<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import Logo from "@/Components/Logo.vue";

const route = useRoute();
const store = useStore();
// handle hamburger menu
const toggleMenu = () => {
  document.getElementById("menuToggle").classList.toggle("active");
  document.querySelector("nav").classList.toggle("z-100");
  document.querySelector(".linksMenu").classList.toggle("show");
  document.querySelector("body").classList.toggle("!overflow-hidden");
};
// computed value for role
const computedRole = computed(() => {
  if (store.getters.getUser) return store.getters.getUser.role == "admin";
  else return false;
});
// show button or not
const isAnnonce = computed(() => {
  return route.path == "/annonce" ? true : false;
});
</script>
<style scoped src="@/assets/css/navbar.css"></style>
