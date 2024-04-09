<template>
  <a class="footer-social-link" :class="props.addClass" :href="link" target="_blank">
    <span class="hidden-link-text">{{ props.name }}</span>
    <slot></slot>
  </a>
</template>
<script setup>

const props = defineProps(["name", "addClass", "link"]);
</script>
