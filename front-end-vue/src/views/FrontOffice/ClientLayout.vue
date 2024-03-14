<template>
  <Navbar />
  <RouterView />
  <Footer />
  <UserActions />
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import UserActions from "@/Components/UserActions.vue";
</script>

<style scoped></style>
