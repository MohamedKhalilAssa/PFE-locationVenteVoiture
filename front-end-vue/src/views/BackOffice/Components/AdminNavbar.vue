<template>
  <div
    class="flex justify-between items-center p-3 md:p-4 md:justify-end bg-whiterounded shadow-lg md:shadow-none md:bg-gray-200 duration-100"
  >
    <SideBar :addClass="show" />
    <div
      id="menuToggle"
      class="animate__animated animate__fadeIn block pt-1 md:hidden"
      @click="toggleMenu"
    >
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav>
      <router-link to="/profile" v-if="$store.getters.getAuthentication">{{
        $store.getters.getUser.nom + " " + $store.getters.getUser.prenom
      }}</router-link>
    </nav>
  </div>
</template>

<script setup>
import SideBar from "@/views/BackOffice/Components/SideBar.vue";
import "animate.css";
import { ref } from "vue";

const show = ref("");

const toggleMenu = () => {
  document.querySelector("#menuToggle").classList.toggle("active");
  if (show.value == "") {
    show.value = "!translate-x-0";
  } else {
    show.value = "";
  }
};
</script>

<style scoped>
#menuToggle {
  position: relative;
  cursor: pointer;
  z-index: 1;
  -webkit-user-select: none;
  user-select: none;
}

#menuToggle span {
  display: block;
  width: 33px;
  height: 4px;
  margin-bottom: 5px;
  position: relative;

  background: #232323;
  border-radius: 3px;

  z-index: 1;

  transform-origin: 4px 0px;

  transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1),
    background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1), opacity 0.55s ease;
}

#menuToggle span:first-child {
  transform-origin: 0% 0%;
}

#menuToggle span:nth-last-child(2) {
  transform-origin: 0% 100%;
}

#menuToggle.active span {
  opacity: 1;
  transform: rotate(-45deg) translate(-3px, -1px);
  background: #232323;
}

#menuToggle.active span:nth-last-child(3) {
  opacity: 0;
  transform: rotate(0deg) scale(0.2, 0.2);
}

#menuToggle.active span:nth-child(2) {
  transform: rotate(45deg) translate(-8px, -7px);
}

.animate__animated.animate__fadeIn {
  --animate-duration: 4s;
}
</style>
