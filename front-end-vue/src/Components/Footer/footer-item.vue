<template>
  <li class="menu-item menu-item-type-post_type menu-item-object-page">
    <router-link :to="props.link">
      <slot></slot>
    </router-link>
  </li>
</template>
<script setup>

const props = defineProps(["link"]);
</script>
