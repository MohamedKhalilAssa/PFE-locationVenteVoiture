<template>
  <div class="main bg-white p-6 rounded-lg">
    <div
      class="modalsContainer flex flex-wrap justify-center gap-4 sm:justify-around"
    >
      <MiniModal
        :endpoint="Endpoints.analytics__get_visitors"
        icon="fa-eye text-red-800 bg-red-300"
        bg="bg-red-200"
      ></MiniModal>
      <MiniModal
        :endpoint="Endpoints.user__get_total"
        icon="fa-users text-blue-800 bg-blue-300"
        bg="bg-blue-200"
      ></MiniModal>
      <MiniModal
        :endpoint="Endpoints.user__get_online_admin"
        icon="fa-user-shield text-yellow-800 bg-yellow-300"
        bg="bg-yellow-100"
      ></MiniModal>
    </div>
    <div
      class="chartContainer !max-h-max flex justify-center sm:justify-around gap-12 flex-wrap mt-20 px-6 w-full mb-16"
    >
      <chartComponent
        v-if="locationByMonth"
        :data="locationByMonth"
        title="Locations par mois"
        bg="1"
        id="locationByMonth"
      ></chartComponent>
      <chartComponent
        v-if="venteByMonth"
        :data="venteByMonth"
        title="Ventes par mois"
        bg="2"
        id="venteByMonth"
      ></chartComponent>
    </div>
  </div>
</template>
<script setup>
import chartComponent from "@/views/BackOffice/AdminComponents/Chart.vue";
import MiniModal from "@/views/BackOffice/AdminComponents/DashboardElements/MiniModal.vue";
import Endpoints from "@/assets/JS/Endpoints";
import getFromDB from "@/Composables/Getters/getFromDB";
import { ref } from "vue";
const locationByMonth = ref(null);
const venteByMonth = ref(null);
getFromDB(Endpoints.traitement_location__getByMonth).then((response) => {
  locationByMonth.value = response;
});
getFromDB(Endpoints.traitement_vente__getByMonth).then((response) => {
  venteByMonth.value = response;
});
</script>
