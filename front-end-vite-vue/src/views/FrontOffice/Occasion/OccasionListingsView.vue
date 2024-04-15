<template>
  <main class="py-10 pl-12 flex flex-wrap justify-center gap-7">
    <DisplayCard v-for="i in 10" :key="i" :data="card"></DisplayCard>
  </main>
</template>
<script setup>
import DisplayCard from "@/Components/DisplayCard.vue";
import { ref } from "vue";

const card = ref({
  titre: "Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport",
  marque: "Toyota",
  model: "Corolla",
  ville: "Stockholm, Sweden",
  prix_vente: 599,
  image: "images/marques/FE2kkZFbrfPT4ObBgsyktee4uardZAwp1VmqCox0.jpg",
});
</script>
<style></style>
