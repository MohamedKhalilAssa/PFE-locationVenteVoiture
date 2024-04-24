<template>
  <div
    class="ImageWrapper fixed top-0 left-0 w-screen h-screen flex justify-center items-center"
    style="z-index: 99999"
  >
    <div
      class="background bg-black opacity-70 absolute top-0 left-0 w-full h-full"
      style="z-index: -1"
      @click.self="emitClosed"
    ></div>
    <div class="image w-3/4 h-3/4">
      <img
        :src="storage + images[curr_image]"
        alt="image"
        class="w-full h-full object-contain"
      />
    </div>
    <div
      class="close absolute cursor-pointer top-2 right-6 w-8 h-8 flex justify-center items-center swipe-right bg-white rounded-full"
      @click="emitClosed"
    >
      <i class="fa-solid text-xl fa-xmark"></i>
    </div>
    <div
      class="absolute cursor-pointer right-6 top-1/2 translate-y-1/2 w-12 h-12 flex justify-center items-center swipe-right bg-white rounded-full"
      @click="nextImage"
      v-if="images.length > 1 && curr_image < images.length - 1"
    >
      <i class="fa-solid text-xl fa-arrow-right"></i>
    </div>
    <div
      class="absolute cursor-pointer left-6 top-1/2 translate-y-1/2 w-12 h-12 flex justify-center items-center swipe-right bg-white rounded-full"
      @click="prevImage"
      v-if="images.length > 1 && curr_image > 0"
    >
      <i class="fa-solid text-xl fa-arrow-left"></i>
    </div>
  </div>
</template>
<script setup>
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";

const props = defineProps(["images", "index"]);
const emits = defineEmits(["closed"]);
const storage = Endpoints.getStoragePath;

const curr_image = ref(props.index);
const emitClosed = () => emits("closed");

const nextImage = () => {
  curr_image.value = (curr_image.value + 1) % props.images.length;
};
const prevImage = () => {
  if (curr_image.value == 0) curr_image.value = props.images.length - 1;
  else curr_image.value = (curr_image.value - 1) % props.images.length;
};
</script>
