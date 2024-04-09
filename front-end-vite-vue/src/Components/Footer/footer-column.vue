<template>
  <div class="footer-content-column" :class="addClass">
    <slot name="logo"></slot>
    <slot></slot>
  </div>
</template>
<script setup>
const props = defineProps(['addClass'])
</script>