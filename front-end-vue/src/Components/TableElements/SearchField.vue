<template>
  <form @submit.prevent="$emit('search', search)" :class="addClass">
    <div class="relative border-2 border-gray-100 m-4 rounded-lg">
      <div class="absolute top-4 left-3">
        <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
      </div>
      <input
        v-model="search"
        @keyup="$emit('search', search)"
        type="text"
        name="search"
        class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
        placeholder="Search ..."
      />
      <div class="absolute top-2 right-2">
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

const search = ref(null);
const props = defineProps(["addClass"]);
</script>
