<template>
  <CardContainer
    :getter="Endpoints.neuf__paginate"
    title="Voitures Neufs"
  ></CardContainer>
</template>
<script setup>
import CardContainer from "@/Components/displayElements/CardContainer.vue";
import Endpoints from "@/assets/JS/Endpoints";
</script>
