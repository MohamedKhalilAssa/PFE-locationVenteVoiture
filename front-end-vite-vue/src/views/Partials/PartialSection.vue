<template>
  <div
    class="relative partialContainer w-full flex justify-center items-center sm:!mb-96"
    style="height: 33rem; margin-bottom: 48rem"
  >
    <div
      class="backgroundImage z-0 absolute top-0 left-0 w-full h-full bg-auto bg-fixed bg-no-repeat bg-left-bottom"
    ></div>
    <div
      class="content absolute z-10 text-4xl sm:text-5xl md:text-6xl text-white font-mono font-bold"
    >
      <p style="max-width: 45rem" class="text-center">
        <span class="text-red-700">Choisissez</span> La Voiture de vos rêves
      </p>
    </div>
    <PartialSearchField
      @updatePage="updatePage"
      :title="title"
      :type="type"
      :getter="getter"
    />
  </div>
</template>
<script setup>
import PartialSearchField from "@/views/Partials/PartialSearchField.vue";

const props = defineProps(["title", "type", "getter"]);
const emit = defineEmits(["updatePage"]);

const updatePage = (data) => {
  emit("updatePage", data);
};
</script>
<style scoped>
.backgroundImage {
  background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)),
    url("@/assets/CompiledImages/PartialsImage.jpg");
}
</style>
