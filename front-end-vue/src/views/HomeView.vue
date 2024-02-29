
<template>
  <main class="min-h-screen">
    <Hero />
  </main>
</template>
<script setup>
import Hero from '@/Components/HeroSection.vue'
import Swal from 'sweetalert2'
import { useRoute } from 'vue-router';

const route = useRoute();

if (route.query.message === 'loggedIn') {
  const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
  Toast.fire({
    icon: "success",
    title: "Connecté avec succès"
  });
}
</script>
<style scoped></style>