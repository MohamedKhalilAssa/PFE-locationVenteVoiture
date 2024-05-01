<template>
  <main class="flex justify-center sm:p-5 mb-14">
    <div
      class="wrapper h-max mt-14 p-4 bg-white rounded-lg max-w-3xl w-full min-h-96 shadow-lg"
    >
      <h3
        class="relative text-2xl mb-6 sm:text-3xl leading-6 font-medium text-gray-900 block after:border-b-4 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-8 pb-2"
      >
        Users
      </h3>
      <div class="usersList">
        <div
          v-for="user in users"
          :key="user.id"
          v-if="users && users[0].id != $store.state.user.id"
        >
          <router-link
            v-if="user.id != $store.state.user.id"
            :to="{ name: 'chatWithView', params: { id: user.id } }"
            class="line cursor-pointer flex items-center justify-between flex-wrap h-28 p-4 border-b-2 border-gray-200 hover:bg-gray-200 gap-2"
          >
            <div class="text">
              <p
                class="text-xl w-52 tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap"
              >
                {{ user.nom + " " + user.prenom }}
              </p>
              <p class="text-lg h-max text-gray-500">{{ user.email }}</p>
            </div>
            <div class="status flex items-center gap-2 w-full sm:w-auto">
              <p class="pb-0.5">online</p>
              <i
                class="fa-solid fa-circle text-green-500 flex items-center"
              ></i>
            </div>
          </router-link>
        </div>
        <div v-else class="text-2xl sm:text-3xl text-center">
          Vous n'etes pas en contact avec d'autres utilisateurs
        </div>
      </div>
    </div>
  </main>
</template>
<script setup>
import { ref } from "vue";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints.js";

const users = ref({});
getFromDB(Endpoints.users__chatted_with).then((response) => {
  users.value = response.message;
});
</script>
