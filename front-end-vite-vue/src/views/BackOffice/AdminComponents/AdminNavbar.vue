<template>
  <div
    class="max-h-24 flex justify-between items-center duration-100 z-50 mb-8 p-3 sticky top-0 md:p-4 bg-white rounded shadow-lg"
  >
    <div class="w-28 hidden md:block"></div>
    <div
      id="menuToggle"
      class="block pt-1 md:hidden"
      :class="{ active: HamburgerClicked }"
      @click="openSideBar"
    >
      <span class="!bg-black"></span>
      <span class="!bg-black"></span>
      <span class="!bg-black"></span>
    </div>
    <Logo
      imageSrc="/assets/images/LogoPNGCroppedR.png"
      toName="homeView"
      class="justify-self-center hidden md:block"
    />

    <SideBar
      :clickedOnMobile="HamburgerClicked"
      @closedSideBar="ClosedSideBar"
    />

    <nav>
      <dropDown :title="$store.getters.getFullName">
        <router-link
          :to="{ name: 'Profile' }"
          class="!flex justify-start items-center gap-2"
        >
          <i class="fa-solid fa-user text-lg"></i>
          <p class="text-lg w-max">Profile</p>
        </router-link>
        <hr />
        <router-link
          class="!flex justify-start items-center"
          :to="{
            name: 'ContactUsBackView',
          }"
          ><button class="!flex justify-center items-center gap-2 !p-0">
            <i class="fa-solid fa-headset text-lg"></i>
            <p class="text-lg w-max">Support Messages</p>
          </button>
        </router-link>
        <router-link
          class="!flex justify-start items-center"
          :to="{
            name: 'chatView',
          }"
          ><button class="!flex justify-center items-center gap-2 !p-0">
            <i class="fa-solid fa-message text-lg"></i>
            <p class="text-lg w-max">Chat</p>
          </button>
        </router-link>
        <hr />

        <hr />
        <form @submit.prevent="logout(route)">
          <button
            type="submit"
            class="!flex justify-start items-center gap-2 w-full"
          >
            <i class="fa-solid fa-sign-out text-lg"></i>
            <p class="text-lg w-max">Logout</p>
          </button>
        </form>
      </dropDown>
    </nav>
  </div>
</template>
<style scoped src="@/assets/css/AdminNavbar.css"></style>
<script setup>
import SideBar from "@/views/BackOffice/AdminComponents/SideBar.vue";
import Logo from "@/Components/Logo.vue";
import dropDown from "@/Components/DropDown.vue";
import { ref } from "vue";
import { useRoute } from "vue-router";
import logout from "@/Composables/AuthenticationRequests/logout";

// for slots
const route = useRoute();
const HamburgerClicked = ref(false);

const openSideBar = () => {
  HamburgerClicked.value = !HamburgerClicked.value;
};
const ClosedSideBar = () => {
  HamburgerClicked.value = false;
};
</script>
