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
<style scoped>
/* Dropdown Button */
/* .dropbtn {
  background-color: #04aa6d;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
} */

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a,
.dropdown-content button {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover,
.dropdown-content button:hover {
  background-color: #ddd;
}

/* Show the dropdown menu on hover */
.dropdown.active .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown.active .dropbtn {
  background-color: rgb(127 29 29);
}
</style>
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
