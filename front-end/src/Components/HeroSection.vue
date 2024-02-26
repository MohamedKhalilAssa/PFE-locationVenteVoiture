<template>
    <section id="hero" class="min-h-screen w-full relative">
        <div class="image absolute top-0 left-0 w-full h-full object-cover bg-center bg-no-repeat"
            :style="{ backgroundImage: `url(${image})`, zIndex: '2' }"></div>
        <div class="background absolute top-0 left-0 w-full h-full bg-black opacity-60 z-10"></div>
    </section>
</template>
  
<script setup>
import { computed, onMounted, ref } from 'vue';
import HeroSectionImage1 from '@/assets/images/HeroSectionImage1.png';
import HeroSectionImage2 from '@/assets/images/HeroSectionImage2.png';

const Images = [
    HeroSectionImage1,
    HeroSectionImage2,
];

const currCounter = ref(0);
const image = computed(() => {
    return Images[currCounter.value];
});

const startSlider = () => {
    const Interval = setInterval(() => {
        currCounter.value = (currCounter.value + 1) % Images.length;
        if (currCounter.value === 0) {
            document.querySelector(".image").classList.add("bg-center");
            document.querySelector(".image").classList.remove("bg-right");

        } else {
            document.querySelector(".image").classList.add("bg-right");
            document.querySelector(".image").classList.remove("bg-center");
        }
    }, 5000);
};
onMounted(() => {
    startSlider();
});
</script>
  
<style scoped></style>
  