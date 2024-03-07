<template>
  <nav
    class="bg-white border border-gray-200 px-2 py-2 rounded shadow-lg flex justify-between items-center w-full h-20 sticky top-0 z-40 lg:px-8"
  >
    <router-link to="/" class="inline-block w-min">
      <div
        class="brand h-full w-48 flex max-h-20 items-baseline mb-2 overflow-hidden"
      >
        <img
          loading="lazy"
          src="../assets/images/LogoPNGCroppedR.png"
          alt="logo"
          class="h-full w-full object-cover"
        />
      </div>
    </router-link>
    <div class="links hidden space-x-4 md:flex">
      <router-link class="link hover:font-bold duration-100" to="/"
        >Home</router-link
      >
      <router-link class="link hover:font-bold duration-100" to="/neuf"
        >Neuf</router-link
      >
      <router-link class="link hover:font-bold duration-100" to="/occasion"
        >Occasion</router-link
      >
      <router-link class="link hover:font-bold duration-100" to="/location"
        >Location</router-link
      >
    </div>
    <div class="btns hidden md:hidden" :class="{ blockImportant: !isAnnonce }">
      <router-link to="/annonce">
        <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-700">
          Ajouter une annonce
        </button>
      </router-link>
    </div>
    <div id="menuToggle" class="block md:hidden" @click="toggleMenu">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </nav>
  <div
    class="linksMenu flex flex-col items-center space-y-5 py-6 fixed left-0 top-20 w-full h-screen z-100 bg-white md:hidden"
  >
    <router-link
      class="linkMob max-w-min hover:font-bold duration-100"
      @click="toggleMenu"
      to="/"
      >Home</router-link
    >
    <router-link
      class="linkMob max-w-min hover:font-bold duration-100"
      @click="toggleMenu"
      to="/neuf"
      >Neuf</router-link
    >
    <router-link
      class="linkMob max-w-min hover:font-bold duration-100"
      @click="toggleMenu"
      to="/occasion"
      >Occasion</router-link
    >
    <router-link
      class="linkMob max-w-min hover:font-bold duration-100"
      @click="toggleMenu"
      to="/location"
      >Location</router-link
    >
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
import { ref, watch } from "vue";
import { useRoute } from "vue-router";

// handle hamburger menu
const toggleMenu = () => {
  document.getElementById("menuToggle").classList.toggle("active");
  document.querySelector("nav").classList.toggle("z-100");
  document.querySelector(".linksMenu").classList.toggle("show");
  document.querySelector("body").classList.toggle("!overflow-hidden");
};

// show button or not
const route = useRoute();
const isAnnonce = ref(true);
watch(route, (to, from) => {
  if (to.path !== "/annonce") {
    isAnnonce.value = false;
  } else {
    isAnnonce.value = true;
  }
});
</script>
<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  right: 0;
  position: absolute;
  min-width: 300px;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/* link */
.link {
  font-size: 1.2rem;
}

/* when a link is active */
.router-link-exact-active {
  font-weight: bold;
}

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

/* show the menu */
.linksMenu {
  left: 100%;
  transition: all 0.5s ease-in-out;
}

.linksMenu.show {
  left: 0%;
}

@media screen and (min-width: 768px) {
  .blockImportant {
    display: block !important;
  }
}

.z-100 {
  z-index: 100;
}
</style>
