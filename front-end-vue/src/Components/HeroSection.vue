<template>
  <section
    id="hero"
    class="w-full relative"
    style="min-height: calc(100vh - 5rem)"
  >
    <div
      class="image absolute top-0 left-0 w-full h-full object-cover bg-bottom bg-no-repeat bg-fixed"
      :style="{ backgroundImage: `url(${image})`, zIndex: '2' }"
    ></div>
    <div
      class="background absolute top-0 left-0 w-full h-full bg-black opacity-70 z-10"
    ></div>
    <div
      class="wrapper flex flex-col justify-center items-center gap-24 absolute top-0 left-0 w-full h-full z-20 lg:flex-row lg:justify-around"
    >
      <div class="text-wrapper flex flex-col justify-end gap-2">
        <h1
          class="text-white text-3xl font-mono font-bold text-center lg:text-left md:text-5xl lg:text-6xl"
        >
          Besoin d'une voiture ?
        </h1>
        <br />
        <h3
          class="text-white text-xl font-mono text-center lg:text-left md:text-3xl lg:text-4xl"
        >
          Vous êtes au bon endroit !
        </h3>
      </div>
      <router-link to="/occasion">
        <button class="btn bg-red-500 text-white px-4 py-3 hover:bg-red-700">
          Acheter une voiture
        </button>
      </router-link>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import HeroSectionImage1 from "@/assets/images/HeroSectionImage1.png";
import HeroSectionImage2 from "@/assets/images/HeroSectionImage2.png";

const Images = [HeroSectionImage1, HeroSectionImage2];

const currCounter = ref(0);
const image = computed(() => {
  return Images[currCounter.value];
});
let Interval;
const startSlider = () => {
  Interval = setInterval(() => {
    currCounter.value = (currCounter.value + 1) % Images.length;
    if (currCounter.value === 0) {
      document.querySelector(".image").classList.add("bg-bottom");
      document.querySelector(".image").classList.remove("bg-right-bottom");
    } else {
      document.querySelector(".image").classList.add("bg-right-bottom");
      document.querySelector(".image").classList.remove("bg-bottom");
    }
  }, 5000);
};
onMounted(() => {
  startSlider();
});
onUnmounted(() => {
  clearInterval(Interval);
});
</script>

<style scoped>
.image {
  transition: background 0.5s ease-in-out;
}
</style>
