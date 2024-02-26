<template>
  <main id="notFoundMain">
    <img
      class="w-full h-full min-h-96 object-cover mx-auto md:w-3/4 xl:w-2/3 2xl:w-1/2"
      src="../assets/images/NotFoundImageNoBG.png"
      alt="page not found Image"
    />
  </main>
</template>
<script setup>
import { watchEffect } from "vue";

const notFoundLink = document.querySelector(".router-link-exact-active");

watchEffect(() => {
  console.log(notFoundLink);
});
// if (notFoundLink.classList.contains("router-link-exact-active")) {
//   document.querySelector("path").style.fill = "#dddcea !important";
// }
</script>
<style>
#notFoundMain {
  min-height: 740px;
}
</style>
