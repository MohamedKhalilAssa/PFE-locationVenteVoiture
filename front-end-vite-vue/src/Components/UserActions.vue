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
        ><Button class="flex justify-start items-center gap-2 text-lg">
          <i class="fa-solid fa-user"></i> Profile
        </Button>
      </router-link>
      <router-link
        :to="{
          name: 'manageAnnoncesView',
        }"
        ><Button class="flex justify-start items-center gap-2">
          <i class="fa-solid fa-cog text-lg"></i>
          <p class="text-lg w-max">Manage annonces</p>
        </Button>
      </router-link>
      <router-link
        :to="{
          name: 'chatView',
        }"
        ><Button class="flex justify-between items-center gap-2">
          <div class="desc flex justify-start items-center flex-row gap-2">
            <i class="fa-solid fa-message text-lg"></i>
            <p class="text-lg w-max">Chat</p>
          </div>
          <div
            class="bg-white w-6 h-6 flex justify-center items-center rounded-full text-red-500"
          >
            {{ notif }}
          </div>
        </Button>
      </router-link>
      <form @submit.prevent="logout(route)">
        <Button class="text-lg flex justify-start items-center gap-2">
          <i class="fa-solid fa-sign-out pt-1"></i>
          <p>Logout</p>
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
      <i
        v-else
        class="fa-solid fa-lock text-2xl"
        :class="{ 'text-red-500': notif != false && !lockClicked }"
        @click="lockClicked = true"
      ></i>
    </div>
  </aside>
</template>

<script setup>
import { onMounted, onUnmounted, ref, watch } from "vue";
import { useRoute } from "vue-router";
import Button from "./ButtonRed.vue";
import logout from "@/Composables/AuthenticationRequests/logout";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";

const aside = ref(null);
const isUserMenu = ref(false);
const notif = ref(false);
const store = useStore();
const lockClicked = ref(false);
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
let counter;
onMounted(() => {
  if (localStorage.getItem("Authentication")) {
    getFromDB(Endpoints.chat__get_notif).then((resp) => {
      notif.value = resp.result;
    });
    setInterval(() => {
      counter = getFromDB(Endpoints.chat__get_notif).then((resp) => {
        notif.value = resp.result;
      });
    }, 6000);
  }
});
onUnmounted(() => {
  clearInterval(counter);
});
</script>

<style scoped>
aside {
  position: fixed;
  width: 250px;
  height: min-content;
  padding: 1rem;
  z-index: 51;
  left: 0;
  top: 25vh;
  background: #fff;
}

.userIcon {
  background: #fff;
}

.blockImportant {
  display: block !important;
}
</style>
