<template>
  <aside class="-translate-x-full duration-500 ease-in-out min-h-screen min-w-52 w-3/5 sm:w-72 md:translate-x-0"
    :class="props.addClass">
    <router-link to="/" class="flex justify-center items-center w-full">
      <div class="brand h-full w-48 flex max-h-20 items-baseline mb-2 overflow-hidden">
        <img loading="lazy" src="@/assets/images/LogoPNGCroppedR.png" alt="logo" class="h-full w-full object-cover" />
      </div>
    </router-link>
  </aside>
</template>
<script setup>
import { watchEffect } from 'vue';

const props = defineProps(['addClass']);

watchEffect(() => {
  console.log(props.addClass)
})
</script>
<style scoped>
aside {
  position: fixed;
  left: 0;
  top: 0;
  background-color: #fff;
}
</style>
