<template>
  
</template>

<script setup>
import { ref } from "vue";

const file = ref(null);

let imageInput = document.querySelector("#img");
let theImage = document.querySelector("#image-upload img");

// imageInput.addEventListener("change", () => {
//   theImage.src = URL.createObjectURL(imageInput.files[0]);
//   theImage.style.height = "100%";
//   theImage.style.width = "100%";
// });
</script>
<style scoped>

</style>
