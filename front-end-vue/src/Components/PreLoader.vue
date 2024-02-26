<template>
    <VuePreloader background-color="#333" color="#EF4444" transition-type="fade-up" :loading-speed="25"
        :transition-speed="1400">

    </VuePreloader>
</template>
<script setup>
import { VuePreloader } from 'vue-preloader';
import '../../node_modules/vue-preloader/dist/style.css'

</script>