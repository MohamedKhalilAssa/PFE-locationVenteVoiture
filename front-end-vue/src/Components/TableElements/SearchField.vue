<template>
  <div
    class="relative m-2 rounded-lg flex flex-col-reverse sm:flex-row justify-between gap-4 "
    :class="addClass"
  >
    <input
      v-model="search"
      @keyup="$emit('search', search, selectedColumn)"
      type="text"
      name="search"
      class="h-10  sm:max-w-64 lg:max-w-96 pl-10 pr-20 rounded-sm z-0 focus:shadow focus:outline-none"
      placeholder="Search ..."
    />
    <select
      class="h-10  pl-10 pr-20 rounded-sm z-0"
      v-model="selectedColumn"
    >
      <option
        scope="row"
        v-for="column in columns"
        :key="column.key"
        :value="column.key"
      >
        {{ column.name }}
      </option>
    </select>
  </div>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps(["addClass", "columns"]);
const search = ref(null);
const selectedColumn = ref(props.columns[0].key);
</script>
