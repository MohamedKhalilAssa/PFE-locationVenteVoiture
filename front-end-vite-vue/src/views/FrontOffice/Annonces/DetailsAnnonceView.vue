<template>
  <main>
    <imageSlider :data="results" addClass="w-full h-72"></imageSlider>
  </main>
</template>
<script setup>
import getById from "@/Composables/Getters/getById";
import Endpoints from "@/assets/JS/Endpoints";
import imageSlider from "@/Components/imageSlider.vue";
import store from "@/store";
import router from "@/router";
import { ref } from "vue";

const props = defineProps(["id"]);
const results = ref({});

// loading the brand
getById(Endpoints.annonce__get_by_id, props.id).then((data) => {
  if (data) {
    results.value = data;
    console.log(results.value);
  } else {
    store.commit("setError", "annonce introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "homeView",
    });
  }
});
</script>
