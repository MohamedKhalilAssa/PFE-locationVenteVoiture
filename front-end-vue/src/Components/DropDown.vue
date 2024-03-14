<template>
  <div class="dropdown" ref="dropdown" @click="toggleMenu">
    <Button class="dropbtn" addClass="rounded">{{ Fullname }}</Button>
    <div class="dropdown-content">
      <router-link to="/profile">Profile</router-link>
      <hr />
      <form @submit.prevent="logout(store, route, router)">
        <button type="submit" class="w-full text-left">Logout</button>
      </form>
    </div>
  </div>
</template>
<style scoped src="@/assets/css/DropDown.css"></style>
<script setup>
import Button from "@/Components/ButtonRed.vue";
import { ref } from "vue";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import logout from "@/Composables/AuthenticationRequests/logout";

const store = useStore();
const route = useRoute();
const router = useRouter();

const dropdown = ref(null);
const Fullname = computed(() => {
  return store.getters.getFullName;
});
const toggleMenu = () => {
  dropdown.value.classList.toggle("active");
};
</script>
