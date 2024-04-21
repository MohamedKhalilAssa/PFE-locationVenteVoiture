<template>
  <CardContainer
    :getter="Endpoints.occasion__paginate"
    title="Voitures d'occasions"
    type="occasion"
  ></CardContainer>
</template>
<script setup>
import CardContainer from "@/Components/displayElements/CardContainer.vue";
import Endpoints from "@/assets/JS/Endpoints";
</script>
