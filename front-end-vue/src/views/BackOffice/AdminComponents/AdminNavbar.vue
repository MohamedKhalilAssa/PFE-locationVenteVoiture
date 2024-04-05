<template>
  <div
    class="max-h-24 flex justify-between items-center duration-100 z-50 mb-8 p-3 sticky top-0 md:p-4 bg-white rounded shadow-lg"
  >
    <div
      id="menuToggle"
      class="block pt-1 md:hidden"
      :class="{ active: sidebarOpen }"
      @click="sidebarOpen = !sidebarOpen"
    >
      <span class="!bg-black"></span>
      <span class="!bg-black"></span>
      <span class="!bg-black"></span>
    </div>
    <Logo
      imageSrc="/assets/images/LogoPNGCroppedR.png"
      toName="home"
      class="justify-self-center"
    />

    <SideBar :addClass="show" />

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
import Logo from "@/Components/Logo.vue";
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
</script>
