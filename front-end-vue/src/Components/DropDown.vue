<template>
  <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
    type="button">

    {{ $store.getters.getUser.nom + " " + $store.getters.getUser.prenom }}
    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
    </svg>
  </button>

  <!-- Dropdown menu -->
  <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
    <div class="px-4 py-3 text-sm text-gray-900">
      <div class="font-medium truncate">{{ $store.getters.getUser.email }}</div>
    </div>
    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformationButton">
      <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
      </li>
      <!-- <li>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Earnings</a>
      </li> -->
    </ul>
    <div class="py-2">
      <form @submit.prevent="logout(store, route, router)">
        <Button> Logout </Button>
      </form>
    </div>
  </div>
</template>
<script setup>
import { useStore } from 'vuex';
import { useRoute, useRouter } from "vue-router";
import logout from "@/Composables/AuthenticationRequests/logout";

const store = useStore();
const router = useRouter();
const route = useRoute();
</script>
