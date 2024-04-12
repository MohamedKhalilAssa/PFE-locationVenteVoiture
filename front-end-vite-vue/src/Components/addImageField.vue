<template>
  <div class="imageFieldContainer mb-6">
    <label
      class="mx-auto overflow-hidden flex justify-center items-center cursor-pointer border-black w-32 h-32 rounded-full"
      for="img"
      :class="{
        'border-red-600': errors && errors.image,
        'border-2': !imageLinkFromParent,
      }"
      ><input
        @change="imageChanged"
        ref="imageInput"
        id="img"
        type="file"
        class="hidden"
      />
      <i
        v-if="!imageLink && !imageLinkFromParent"
        class="fa-solid fa-plus text-3xl duration-300"
      ></i>
      <img
        v-else
        alt="image of the uploaded file"
        ref="theImage"
        :src="imageLink || imageLinkFromParent"
        class="w-full h-full object-cover"
      />
    </label>
    <p class="text-center">Ajouter une image de la marque (png,jpeg,jpg...)</p>
    <p
      class="text-red-600 text-center"
      v-if="errors && errors.image"
      v-for="error of errors.image"
      :key="error"
    >
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { ref } from "vue";

let imageInput = ref(null);
let imageLink = ref(null);
const emits = defineEmits(["imageChanged"]);
const props = defineProps(["errors", "imageLinkFromParent"]);

const imageChanged = (e) => {
  if (imageInput.value.files[0]) {
    imageLink.value = URL.createObjectURL(imageInput.value.files[0]);
    emits("imageChanged", imageInput.value.files[0]);
  }
};
</script>
<style scoped>
label:hover i {
  transform: scale(1.1);
}
</style>
