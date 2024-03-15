<template>
  <div
    class="max-h-24 flex justify-between items-center duration-100 z-50 mb-8 p-3 sticky top-0 md:p-4 md:justify-end bg-white rounded shadow-lg md:shadow-none md:bg-gray-200">
    <SideBar :addClass="show" />
    <div id="menuToggle" class="animate__animated animate__fadeIn block pt-1 md:hidden" @click="toggleMenu">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav>
      <dropDown :title="$store.getters.getFullName">
        <router-link to="/profile">Profile</router-link>
        <hr />
        <form @submit.prevent="logout(store, route, router)">
          <button type="submit" class="w-full text-left">Logout</button>
        </form>
      </dropDown>
    </nav>
  </div>
</template>

<script setup>
import SideBar from "@/views/BackOffice/AdminComponents/SideBar.vue";
import dropDown from "@/Components/DropDown.vue";
import "animate.css";
import { ref } from "vue";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";
import logout from "@/Composables/AuthenticationRequests/logout";

// for slots
const store = useStore();
const route = useRoute();
const router = useRouter();

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

<style scoped src="@/assets/css/AdminNavbar.css"></style>
