<template>
  <PreLoader />
  <ClientLayout v-if="!$route.path.startsWith('/admin')" />
  <AdminLayout v-if="$route.path.startsWith('/admin')" />
</template>

<script setup>
import PreLoader from "@/Components/PreLoader.vue";
import ClientLayout from "@/views/FrontOffice/ClientLayout.vue";
import AdminLayout from "@/views/BackOffice/AdminLayout.vue";
import getCSRFToken from "@/Composables/Getters/getCSRFToken";
import flashCard from "@/Composables/ErrorSuccessMessages/flashCard";
import errorFlashCard from "./Composables/ErrorSuccessMessages/errorFlashCard";
import { onMounted } from "vue";
import { useStore } from "vuex";
import { watch } from "vue";
import { useRoute } from "vue-router";

onMounted(() => {
  // setting authentication and user in the store
  const route = useRoute();
  const store = useStore();
  store.commit("setAuthentication");
  store.commit("setUser");
  // setting csrf token and verifying auth at first mounted
  getCSRFToken();
  // handling success messages on change in the store
  watch(
    () => store.getters.getMessage,
    (newMessage, oldMessage) => {
      if (newMessage) {
        let iconColor = store.getters.getIconColor;
        flashCard(newMessage, iconColor).then(() => {
          store.commit("setMessage", null);
          store.commit("setIconColor", "green");
        });
      }
    }
  );
  // handling error messages on change in the store
  watch(
    () => store.getters.getError,
    (newError, oldError) => {
      if (newError) {
        if (newError.response) {
          errorFlashCard(newError).then(() => {
            store.commit("setError", null);
          });
        } else {
          let code = store.getters.getErrorCode;
          errorFlashCard(newError, code).then(() => {
            store.commit("setError", null);
            store.commit("setErrorCode", null);
          });
        }
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
.swal2-container {
  z-index: 90;
}
#app {
  min-height: 100vh;
}
</style>
