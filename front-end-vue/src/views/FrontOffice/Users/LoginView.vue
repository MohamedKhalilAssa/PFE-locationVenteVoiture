<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <form
      method="POST"
      action=""
      @submit.prevent="loginHandler"
      class="bg-white border border-gray-900 shadow-2xl p-4 sm:p-6 md:p-10 rounded max-w-lg"
    >
      <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">Login</h2>
      </header>

      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2 required"
          >Email</label
        >
        <input
          v-model="form.email"
          id="email"
          type="email"
          class="border border-gray-600 rounded p-2 w-full"
          name="email"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
      </div>

      <div class="mb-6">
        <label for="password" class="inline-block text-lg mb-2 required"
          >Password</label
        >
        <input
          v-model="form.password"
          id="password"
          type="password"
          class="border border-gray-600 rounded p-2 w-full"
          name="password"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.password">
            {{ errors.password[0] }}
          </p>
        </div>
      </div>

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Se Connecter
        </button>
      </div>

      <div class="mt-8">
        <p>
          Vous n'avez pas de compte?
          <router-link
            to="/register"
            class="text-blue-500 hover:scale-105 duration-300 inline-block"
            >Creer un compte
          </router-link>
        </p>
      </div>
    </form>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";
import login from "@/Composables/AuthenticationRequests/login";

const form = ref({
  email: null,
  password: null,
});

const errors = ref(null);
const router = useRouter();
const store = useStore();
const button = ref(null);
const route = useRoute();

const loginHandler = async () => {
  await login(button.value, form, router, route, store, errors);
};
</script>

<style scoped>
section {
  min-height: calc(100vh - 11rem);
}
</style>
