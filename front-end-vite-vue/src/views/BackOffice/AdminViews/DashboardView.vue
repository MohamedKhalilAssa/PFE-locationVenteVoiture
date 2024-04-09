<template>
  <div
    class="modalsContainer flex flex-wrap justify-center gap-4 sm:justify-around"
  >
    <MiniModal
      :endpoint="Endpoints.analytics__get_visitors"
      icon="fa-eye text-red-800 bg-red-300"
    ></MiniModal>
    <MiniModal
      :endpoint="Endpoints.user__get_total"
      icon="fa-users text-blue-800 bg-blue-300"
    ></MiniModal>
    <MiniModal
      :endpoint="Endpoints.user__get_online_admin"
      icon="fa-user-shield text-yellow-800 bg-yellow-300"
    ></MiniModal>
  </div>
  <chartComponent v-if="false"></chartComponent>
</template>
<script setup>
import chartComponent from "@/views/BackOffice/AdminComponents/Chart.vue";
import MiniModal from "@/views/BackOffice/AdminComponents/DashboardElements/MiniModal.vue";
import Endpoints from "@/assets/JS/Endpoints";
</script>
