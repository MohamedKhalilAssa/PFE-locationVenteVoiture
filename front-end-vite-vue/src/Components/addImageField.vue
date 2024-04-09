<template>
  <div class="image-field">
    <label for="img" id="image-upload"
      ><i class="fa-solid fa-plus plus-icon"></i
    ></label>
    <p id="img-para">Add image(png,jpg,jpeg...)</p>
    <input id="img" class="input" type="file" name="image" />
  </div>
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
/* Image Styling */
#image-upload {
  display: inline-block;
  width: 90px;
  height: 90px;
  border: 5px solid var(--input-color-gray);
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  margin: auto;
  overflow: hidden;
}
.plus-icon {
  width: 50px;
  height: 50px;
  opacity: 0.7;
  object-fit: cover;
}
#img {
  display: none;
}
.image-field {
  display: none;
  margin-bottom: 0rem;
  transition: all 0.3s ease-in;
  overflow: hidden;
}
#img-para {
  width: 100%;
  display: inline-block;
  margin-top: 0.5rem;
  text-align: center;
}
.text-center {
  text-align: center;
  width: 100%;
}
/* ends */
</style>
