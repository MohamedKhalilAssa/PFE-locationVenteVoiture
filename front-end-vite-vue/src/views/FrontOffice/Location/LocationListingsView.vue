<template>
  <CardContainer
    :getter="Endpoints.location__paginate"
    title="Voitures de Locations"
    type="location"
  ></CardContainer>
</template>
<script setup>
import CardContainer from "@/Components/displayElements/CardContainer.vue";
import Endpoints from "@/assets/JS/Endpoints";
</script>
