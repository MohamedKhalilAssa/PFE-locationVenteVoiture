<template>
  <Navbar />
  <RouterView />
  <Footer />
  <PreLoader />
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { onMounted } from 'vue';
import PreLoader from './Components/PreLoader.vue';

</script>

<style>
body {
  overflow-x: hidden;
}

main {
  background-color: #e5e7eb;
}

#app {
  min-height: 100vh;
}
</style>
