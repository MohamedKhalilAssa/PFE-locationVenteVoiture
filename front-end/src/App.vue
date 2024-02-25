<template>
  <Navbar />
  <RouterView />
  <Footer />
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script>

<style>
body {
  overflow-x: hidden;
}

#app {
  min-height: 100vh;
}
</style>
