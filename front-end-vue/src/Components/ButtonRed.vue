<template>
  <button
    class="btn bg-red-500 text-white px-4 py-3 w-full hover:bg-red-700 cursor-pointer"
    :class="props.addClass"
  >
    <slot></slot>
  </button>
</template>
<script setup>
const props = defineProps(["addClass"]);
</script>
