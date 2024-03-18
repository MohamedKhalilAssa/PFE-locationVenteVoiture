<template>
  <PreLoader />
  <ClientLayout v-if="!$route.path.startsWith('/admin')" />
  <AdminLayout v-if="$route.path.startsWith('/admin')" />
</template>

<script setup>
import PreLoader from "./Components/PreLoader.vue";
import ClientLayout from "./views/FrontOffice/ClientLayout.vue";
import AdminLayout from "./views/BackOffice/AdminLayout.vue";
import VerifyAuth from "@/Composables/AuthenticationRequests/VerifyAuth";
import { onMounted } from "vue";
import { useStore } from "vuex";
import { watch } from "vue";
import { useRoute } from "vue-router";
import flashCard from "@/Composables/ErrorSuccessMessages/flashCard";

onMounted(() => {
  // setting authentication and user in the store
  const route = useRoute();
  const store = useStore();
  store.commit("setAuthentication");
  store.commit("setUser");

  VerifyAuth(store);
  watch(
    () => store.getters.getMessage,
    (newMessage, oldMessage) => {
      if (newMessage) {
        console.log(newMessage);
        let iconColor = store.getters.getIconColor;
        flashCard(newMessage, iconColor).then((response) => {
          store.commit("setMessage", null);
          store.commit("setIconColor", "green");
        });
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
@/Composables/ErrorSuccessMessages/errorMessage@/Composables/ErrorSuccessMessages/successLoggedIn./Components/flashCard.js
