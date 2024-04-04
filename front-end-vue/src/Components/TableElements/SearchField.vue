<template>
  <form
    @submit.prevent="$emit('search', search, selectedColumn)"
    :class="addClass"
  >
    <div
      class="relative m-2 rounded-lg flex justify-around flex-col gap-4 lg:flex-row"
    >
      <select
        class="h-10 max-w-max pl-10 pr-20 rounded-lg z-0"
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
      <div
        class="searchContainer flex flex-col sm:flex-row md:items-center gap-4 sm:w-72 max-w-max"
      >
        <input
          v-model="search"
          @keyup="$emit('search', search, selectedColumn)"
          type="text"
          name="search"
          class="h-10 sm:min-w-60 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none maxFix"
          placeholder="Search ..."
        />
        <div class="w-full">
          <button
            id="btn"
            type="submit"
            class="h-10 min-w-12 px-3 w-full text-white rounded-lg bg-red-600 hover:bg-red-800 duration-100"
          >
            Search
          </button>
        </div>
      </div>
    </div>
  </form>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps(["addClass", "columns"]);
const search = ref(null);
const selectedColumn = ref(props.columns[0].key);
</script>
<style>
/* @media screen and (max-width: 326px) {
  .maxFix {
    max-width: 100% !important;
  }
} */
</style>
