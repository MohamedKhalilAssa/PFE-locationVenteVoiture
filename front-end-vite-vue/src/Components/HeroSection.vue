<template>
  <div
    class="relative partialContainer mt-4 w-full flex justify-center mx-auto rounded-xl items-center"
    style="height: 35rem; max-width: 98vw"
  >
    <div
      class="backgroundImage z-0 absolute top-0 left-0 w-full h-full bg-cover rounded-xl bg-no-repeat bg-left-bottom"
    ></div>
    <div class="content absolute z-10 text-white font-mono">
      <p class="text-center hidden sm:block" style="font-size: 1rem">
        acheter ou louer des voitures en toute simplicité
      </p>
      <p
        style="max-width: 45rem"
        class="text-center text-4xl sm:text-5xl md:text-6xl font-bold"
      >
        <span class="text-red-700">Trouver</span> La Voiture parfaite
      </p>
    </div>
  </div>
</template>
<script setup>
// const props = defineProps(["title", "type", "getter", "filters"]);
// const emit = defineEmits(["updatePage"]);
</script>
<style scoped>
.backgroundImage {
  background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)),
    url("@/assets/CompiledImages/banner-page1.jpg");
}
.underline {
  border-bottom: 1px solid white;
}
</style>
