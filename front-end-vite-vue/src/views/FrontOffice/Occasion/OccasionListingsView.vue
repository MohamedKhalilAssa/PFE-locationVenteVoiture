<template>
  <main class="py-10 px-12 flex flex-wrap justify-center gap-7">
    <DisplayCard
      v-for="annonce in occasion"
      :key="annonce.id"
      :data="annonce"
    ></DisplayCard>
  </main>
</template>
<script setup>
import DisplayCard from "@/Components/DisplayCard.vue";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";

const occasion = ref([]);

getFromDB(Endpoints.occasion__get_all_or_add).then((response) => {
  if (response) {
    occasion.value = response;
    console.log(occasion.value);
  }
});

const card = ref({
  titre: "Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport",
  marque: "Toyota",
  model: "Corolla",
  ville: "Stockholm, Sweden",
  prix_vente: 599,
  image:
    "https://img.freepik.com/free-photo/white-offroader-jeep-parking_114579-4007.jpg?size=626&ext=jpg&ga=GA1.1.1330132642.1708895587&semt=sph",
});
</script>
<style></style>
