<template>
  <div class="w-80 max-h-max bg-white shadow-lg rounded-lg p-3" style="max-height: 485px" :title="data.titre">
    <imageSlider :data="data" :isLink="true" addClass="w-full h-72"></imageSlider>
    <router-link :to="{ name: 'detailsAnnonceFront', params: { id: data.id } }">
      <div class="content py-4 space-y-1">
        <h3 class="text-xl font-semibold tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap">
          {{ data.titre }}
        </h3>
        <p class="space-x-3 text-ellipsis overflow-hidden whitespace-nowrap">
          <i class="fa-solid text-center fa-car w-5"></i><span class="text-lg text-gray-700">{{
    data["marque.nom"] +
    ", " +
    data["modele.nom"] +
    " - " +
    data["annee_fabrication"]
  }}</span>
        </p>
        <p class="location space-x-3">
          <i class="fa-solid fa-location-dot text-center text-lg w-5"></i>
          <span class="text-lg text-gray-700">{{ data["ville.nom"] }}</span>
        </p>
        <p class="carburant space-x-3">
          <i class="fa-solid fa-gas-pump text-right text-lg w-5"></i>
          <span class="text-lg text-gray-700">{{ data["carburant"] }}</span>
        </p>
        <p class="location space-x-3">
          <i class="fa-solid fa-money-bill text-end text-lg w-5"></i>
          <span class="text-xl text-gray-700">{{
    data["type_annonce"] == "location"
      ? parseInt(data["prix_location"]) + " MAD / Jour"
            : parseInt(data["prix_vente"]) + " MAD" ?? "N/A"
            }}
          </span>
        </p>
      </div>
    </router-link>
  </div>
</template>
<script setup>
import imageSlider from "@/Components/imageSlider.vue";
const props = defineProps(["data"]);
</script>
