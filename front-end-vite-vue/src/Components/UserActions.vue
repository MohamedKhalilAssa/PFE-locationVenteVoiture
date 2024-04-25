<template>
  <aside
    class="-translate-x-full duration-500 ease-in-out"
    ref="aside"
    v-if="!isUserMenu"
  >
    <div
      class="userActions flex flex-col justify-around gap-8"
      v-if="!$store.getters.getAuthentication"
    >
      <router-link :to="{ name: 'Login', query: { previous: route.name } }">
        <Button> Login </Button>
      </router-link>
      <router-link :to="{ name: 'Register' }">
        <Button> Register </Button>
      </router-link>
    </div>
    <div class="userActions flex flex-col justify-around gap-8" v-else>
      <router-link :to="{ name: 'Profile' }"
        ><Button class="flex justify-center items-center gap-2">
          <i class="fa-solid fa-user"></i> Profile
        </Button>
      </router-link>
      <router-link
        :to="{
          name: 'manageAnnoncesView',
        }"
        ><Button class="flex justify-center items-center gap-2">
          <i class="fa-solid fa-cog text-sm"></i>
          <p class="text-sm w-max">Manage annonces</p></Button
        >
      </router-link>
      <form @submit.prevent="logout(route)">
        <Button class="flex justify-center items-center gap-2"
          ><p>Logout</p>
          <i class="fa-solid fa-sign-out"></i>
        </Button>
      </form>
    </div>
    <div
      class="userIcon absolute -right-9 top-0 cursor-pointer min-w-4 px-2 py-1"
      @click="showUserActions"
    >
      <i
        v-if="!$store.getters.getAuthentication"
        class="fa-solid fa-user text-2xl"
      ></i>
      <i v-else class="fa-solid fa-lock text-2xl"></i>
    </div>
  </aside>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import Button from "./ButtonRed.vue";
import logout from "@/Composables/AuthenticationRequests/logout";

const aside = ref(null);
const isUserMenu = ref(false);

// using vue elements
const route = useRoute();

watch(route, (to, from) => {
  if (to.path !== "/register" && to.path !== "/login") {
    isUserMenu.value = false;
  } else {
    isUserMenu.value = true;
  }
});
const showUserActions = () => {
  aside.value.classList.toggle("-translate-x-full");
  if (!isUserMenu.value) {
    setTimeout(() => {
      if (aside.value) {
        if (!aside.value.classList.contains("-translate-x-full"))
          aside.value.classList.add("-translate-x-full");
      }
    }, 5500);
  }
};
</script>

<style scoped>
aside {
  position: fixed;
  width: 200px;
  height: min-content;
  padding: 1rem;
  z-index: 51;
  left: 0;
  top: 20vh;
  background: #fff;
}

.userIcon {
  background: #fff;
}

.blockImportant {
  display: block !important;
}
</style>
