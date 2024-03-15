<template>
  <Navbar />
  <main class="p-4 md:ml-72 lg:p-8">
    <RouterView />
  </main>
</template>

<script setup>
import Navbar from "@/views/BackOffice/AdminComponents/AdminNavbar.vue";
</script>

<style scoped></style>
