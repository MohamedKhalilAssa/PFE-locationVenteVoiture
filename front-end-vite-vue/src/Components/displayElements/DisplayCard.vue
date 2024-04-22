<template>
  <div
    class="w-80 max-h-max bg-white shadow-lg rounded-lg p-3"
    style="max-height: 470px"
  >
    <div class="imgContainer relative w-full h-72 rounded-lg">
      <router-link to="/neuf">
        <img
          :src="Endpoints.getStoragePath + images[curr_image]"
          alt="image"
          class="w-full h-full object-cover rounded-lg"
        />
      </router-link>
      <div
        class="absolute cursor-pointer right-2 top-1/2 translate-y-1/2 w-8 h-8 flex justify-center items-center swipe-right bg-white rounded-full"
        @click="nextImage"
        v-if="images.length > 1 && curr_image < images.length - 1"
      >
        <i class="fa-solid text-xl fa-arrow-right"></i>
      </div>
      <div
        class="absolute cursor-pointer left-2 top-1/2 translate-y-1/2 w-8 h-8 flex justify-center items-center swipe-right bg-white rounded-full"
        @click="prevImage"
        v-if="images.length > 1 && curr_image > 0"
      >
        <i class="fa-solid text-xl fa-arrow-left"></i>
      </div>
    </div>
    <router-link to="/neuf">
      <div class="content py-4 space-y-1">
        <h3
          class="text-xl font-semibold tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap"
        >
          {{ data.titre }}
        </h3>
        <p class="space-x-3 text-ellipsis overflow-hidden whitespace-nowrap">
          <i class="fa-solid text-center fa-car w-5"></i
          ><span class="text-lg text-gray-700">{{
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
        <p class="location space-x-3">
          <i class="fa-solid fa-money-bill text-center text-lg w-5"></i>
          <span class="text-xl text-gray-700"
            >{{
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
import Endpoints from "@/assets/JS/Endpoints";
import { computed, ref } from "vue";
const props = defineProps(["data"]);
const images = computed(() => JSON.parse(props.data["image"]));
const curr_image = ref(0);

const nextImage = () => {
  curr_image.value = (curr_image.value + 1) % images.value.length;
};
const prevImage = () => {
  if (curr_image.value == 0) curr_image.value = images.value.length - 1;
  else curr_image.value = (curr_image.value - 1) % images.value.length;
};
</script>
