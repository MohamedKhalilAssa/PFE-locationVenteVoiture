<template>
  <div class="w-full max-h-sm max-w-96 rounded-lg">
    <div class="imgContainer w-full h-72 rounded-lg">
      <img
        :src="Endpoints.getStoragePath + data.image"
        alt="image"
        class="w-full h-full object-cover rounded-lg"
      />
    </div>
    <div class="content py-4 space-y-1">
      <h3
        class="text-xl font-semibold tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap"
      >
        {{ data.nom }}
      </h3>
      <p>{{ data.marque + "," + data.model }}</p>
      <div class="flex items-center justify-between">
        <div class="location space-x-3">
          <i class="fa-solid fa-location-dot"></i>
          <span class="text-lg text-gray-700">{{ data.ville }}</span>
        </div>
        <span class="text-3xl font-bold text-gray-900"
          >{{ data.prix_vente }} Dhs</span
        >
      </div>
    </div>
  </div>
</template>
<script setup>
import Endpoints from "@/assets/JS/Endpoints";
const props = defineProps(["data"]);
</script>
