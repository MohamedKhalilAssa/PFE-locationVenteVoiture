<template>
  <div
    class="relative m-2 rounded-lg flex flex-col-reverse justify-between items-center gap-4 sm:flex-row"
    :class="addClass"
  >
    <input
      v-model="search"
      @keyup="
        $emit('search', search, searchColumn || columns[1].key, columns[0].key)
      "
      type="text"
      name="search"
      class="h-10 sm:max-w-64 lg:max-w-96 pl-10 pr-20 rounded-sm z-0 focus:shadow focus:outline-none"
      placeholder="Search ..."
    />
    <select
      class="h-10 rounded-sm z-0"
      v-model="searchColumn"
      @change="
        $emit('search', search, searchColumn || columns[1].key, columns[0].key)
      "
    >
      <option selected value="">Filter By</option>
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
const searchColumn = ref("");
</script>
