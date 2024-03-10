<template>
  <aside class="-translate-x-full duration-500 ease-in-out" ref="aside" v-if="!isUserMenu">
    <div class="userActions flex flex-col justify-around gap-8" v-if="!$store.getters.getAuthentication">
      <router-link :to="{ name: 'Login', query: { previous: route.name } }">
        <Button> Login </Button>
      </router-link>
      <router-link :to="{ name: 'Register' }">
        <Button> Register </Button>
      </router-link>
    </div>
    <div class="userActions flex flex-col justify-around gap-8" v-else>
      <form @submit.prevent="logout">
        <Button> Logout </Button>
      </form>
    </div>
    <div class="userIcon absolute -right-9 top-0 cursor-pointer min-w-4 px-2 py-1" @click="showUserActions">
      <i class="fa-solid fa-user text-2xl"></i>
    </div>
  </aside>
</template>

<script setup>
import Swal from "sweetalert2";
import axios from "axios";
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import Button from "./ButtonRed.vue";
import { useStore } from "vuex";

const aside = ref(null);
const isUserMenu = ref(false);

// using vue elements
const route = useRoute();
const router = useRouter();
const store = useStore();

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
    }, 4500);
  }
};
const logout = async () => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/logout");
    if (route.meta.requiresAuth) {
      router.push({ name: "home", query: { message: "loggedOut" } });
    }
    // taking out the user from storage/store
    sessionStorage.removeItem("Authentication");
    sessionStorage.removeItem("User");
    sessionStorage.removeItem("authMessage");
    store.commit("setAuthentication");
    store.commit("setUser");

    // Show succes message
    const Toast = Swal.mixin({
      toast: true,
      position: "bottom-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
    Toast.fire({
      icon: "success",
      iconColor: "red",
      title: "Déconnecté avec succès",
    });

  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error.message,
    });
    sessionStorage.removeItem("Authentication");
    sessionStorage.removeItem("User");
    sessionStorage.removeItem("authMessage");
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
  top: 30vh;
  background: #fff;
}

.userIcon {
  background: #fff;
}

.blockImportant {
  display: block !important;
}
</style>
