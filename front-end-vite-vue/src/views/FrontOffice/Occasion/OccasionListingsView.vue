<template>
  <CardContainer
    :getter="Endpoints.occasion__paginate"
    title="Voitures d'occasions"
    :filters="filters"
    type="occasion"
  ></CardContainer>
</template>
<script setup>
import CardContainer from "@/Components/displayElements/CardContainer.vue";
import Endpoints from "@/assets/JS/Endpoints";
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
const route = useRoute();
const filters = ref(route.query.filters);
watch(
  () => route.query.filters,
  (newVal, old) => {
    if (newVal) {
      filters.value = newVal;
    }
  }
);
</script>
