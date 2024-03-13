<template>
  <PreLoader />
  <ClientLayout v-if="!$route.path.startsWith('/admin')" />
  <AdminLayout v-if="$route.path.startsWith('/admin')" />
  <UserActions />
</template>

<script setup>
import UserActions from "@/Components/UserActions.vue";
import PreLoader from "./Components/PreLoader.vue";
import ClientLayout from "./views/FrontOffice/ClientLayout.vue";
import AdminLayout from "./views/BackOffice/AdminLayout.vue";
import { onMounted, watchEffect } from "vue";
import { useStore } from "vuex";
import { watch, ref } from "vue";
import successLoggedInMessage from "@/Composables/successLoggedIn";
import errorMessage from "@/Composables/errorMessage";
import { useRoute } from "vue-router";
import VerifyAuth from "@/Composables/VerifyAuth";

onMounted(() => {
  // setting authentication and user in the store
  const route = useRoute();
  const store = useStore();
  store.commit("setAuthentication");
  store.commit("setUser");
  
  VerifyAuth(store);
  // handle success message
  watch(
    () => route.path,
    (newPath, oldPath) => {
      if (newPath != "/login" && newPath != "/register") {
        successLoggedInMessage(route.query.message || null, store);
      }
    }
  );
  watchEffect(() => {
    if (route.query.error == "unAuthorized" && !sessionStorage.getItem("unauthorizedMessage")) {
      errorMessage(route.query.error || null);
    }
  })
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
</style>@/Composables/unauthorizedMessage
