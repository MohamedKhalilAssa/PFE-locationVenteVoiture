<template>
  <div class="imgContainer relative rounded-lg" :class="addClass">
    <router-link
      v-if="isLink"
      :to="{ name: 'detailsAnnonceFront', params: { id: data.id } }"
      @click="emitImage"
    >
      <img
        :src="Endpoints.getStoragePath + images[curr_image]"
        alt="image"
        class="w-full h-full object-cover rounded-lg"
      />
    </router-link>
    <img
      v-else
      :src="Endpoints.getStoragePath + images[curr_image]"
      alt="image"
      class="w-full h-full object-cover rounded-lg"
      @click="emitImage"
    />
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
</template>
<script setup>
import Endpoints from "@/assets/JS/Endpoints";
import { computed, ref, watch } from "vue";
const props = defineProps(["data", "isLink", "addClass", "images"]);
const images = computed(() => {
  return props.images ? props.images : JSON.parse(props.data["image"]);
});
const curr_image = ref(0);
watch(()=>props.images, (to, from) => {
  if (to != from) {
    if(curr_image.value != 0) curr_image.value = 0
  }
})

const emits = defineEmits(["clicked"]);
const emitImage = () => emits("clicked", images.value, curr_image.value);
const nextImage = () => {
  curr_image.value = (curr_image.value + 1) % images.value.length;
};
const prevImage = () => {
  if (curr_image.value == 0) curr_image.value = images.value.length - 1;
  else curr_image.value = (curr_image.value - 1) % images.value.length;
};
</script>
