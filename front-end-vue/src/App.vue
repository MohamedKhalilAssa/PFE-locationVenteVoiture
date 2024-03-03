<template>
  <PreLoader />
  <Navbar />
  <UserActions />
  <RouterView />
  <Footer />
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import UserActions from "@/Components/UserActions.vue";
import PreLoader from "./Components/PreLoader.vue";
import { onMounted } from "vue";
import { useStore } from "vuex";
import { watch, ref } from "vue";
import successLoggedInMessage from "@/Composables/successLoggedIn";
import { useRoute } from "vue-router";

onMounted(() => {
  // setting authentication and user in the store
  const route = useRoute();
  const store = useStore();
  store.commit("setAuthentication");
  store.commit("setUser");

  // handle success message
  watch(
    () => route.path,
    (newPath, oldPath) => {
      if (newPath != "/login" && newPath != "/register") {
        successLoggedInMessage(route.query.message || null);
      }
    }
  );
});
</script>

<style>
body {
  overflow-x: hidden;
}

main {
  background-color: #e5e7eb;
  min-height: calc(100vh - 7rem);
}

#app {
  min-height: 100vh;
}
</style>
