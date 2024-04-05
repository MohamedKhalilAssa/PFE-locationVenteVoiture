<template>
  <Navbar />
  <main class="p-4 md:ml-14 md:p-8">
    <RouterView />
  </main>
</template>

<script setup>
import Navbar from "@/views/BackOffice/AdminComponents/AdminNavbar.vue";
</script>

<style scoped></style>
