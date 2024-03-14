<template>
  <a
    class="footer-social-link"
    :class="props.addClass"
    :href="link"
    target="_blank"
  >
    <span class="hidden-link-text">{{ props.name }}</span>
    <slot></slot>
  </a>
</template>
<script setup>
import { defineProps } from "vue";

const props = defineProps(["name", "addClass", "link"]);
</script>
