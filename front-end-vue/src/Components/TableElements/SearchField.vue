<template>
  <form @submit.prevent="$emit('search', search,selectedColumn)" :class="addClass">

    <div class="relative border-2 border-gray-100 m-2 rounded-lg">
      <select class="h-14 w-30 pl-10 pr-20 rounded-lg z-0 " v-model="selectedColumn">
        <option
            scope="row"
            v-for="column in columns"
            :key="column.key"
            :value="column.key"
        >
          {{ column.name }}
        </option>
      </select>

      <input
        v-model="search"
        @keyup="$emit('search', search,selectedColumn)"
        type="text"
        name="search"
        class="h-14 w-50 pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
        placeholder="Search ..."
      />
      <div class="absolute top-2 right-60">
        <button
          type="submit"
          class="h-10 w-20 text-white rounded-lg bg-red-600 hover:bg-red-800 duration-100"
        >
          Search
        </button>
      </div>
    </div>
  </form>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps(["addClass","columns"]);
const search = ref(null);
const selectedColumn = ref(props.columns[0].key);
</script>
