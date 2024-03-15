<template>
  <div class="dropdown" ref="dropdown" @click="toggleMenu">
    <Button class="dropbtn" addClass="rounded">{{ props.title }}</Button>
    <div class="dropdown-content">
      <!-- more customizable and reusable  -->
      <slot></slot>
    </div>
  </div>
</template>
<style src="@/assets/css/DropDown.css"></style>
<script setup>
import Button from "@/Components/ButtonRed.vue";
import { ref } from "vue";


const props = defineProps(["title"]);
const dropdown = ref(null);

const toggleMenu = () => {
  dropdown.value.classList.toggle("active");
};
</script>
