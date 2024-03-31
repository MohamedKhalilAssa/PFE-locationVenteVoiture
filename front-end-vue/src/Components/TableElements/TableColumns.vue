<template>
  <!-- columns = [{name: ,key: },{}] -->
  <th scope="col" class="px-6 py-3" v-for="column in columns" :key="column.key">
    {{ column.name }}
  </th>
  <th scope="col" class="px-6 py-3">Actions</th>
</template>
<script setup>
const props = defineProps(["columns"]);
</script>
