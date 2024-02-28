<template>
  <PreLoader />
  <Navbar />
  <UserActions />
  <RouterView />
  <Footer />
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import UserActions from '@/Components/UserActions.vue';
import PreLoader from './Components/PreLoader.vue';
import { onMounted } from 'vue';
import { useStore } from 'vuex';


onMounted(() => {
  const store = useStore()
  store.commit('setAuthentication')
  store.commit('setUser')
})
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
