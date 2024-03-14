<template>
  <div class="footer-menu">
    <h2 class="footer-menu-name" v-html="props.titre"></h2>
    <ul id="menu-company" class="footer-menu-list">
      <slot></slot>
    </ul>
  </div>
</template>
<script setup>

const props = defineProps(["titre"]);
</script>
