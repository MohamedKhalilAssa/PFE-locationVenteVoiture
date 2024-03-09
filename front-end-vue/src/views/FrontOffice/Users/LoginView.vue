<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <form
      method="POST"
      action=""
      @submit.prevent="LoginHandling"
      class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-lg"
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

      <div class="mb-6">
        <button
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
    <div
      class="errors max-w-lg text-center mx-auto mb-10 mt-10"
      v-if="serverError"
    >
      <p
        class="text-red-600"
        v-html="serverError"
        @change="setTimeout(() => (serverError = null), 2000)"
      ></p>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";

const form = ref({
  email: null,
  password: null,
});

const user = ref(null);
const errors = ref(null);
const serverError = ref(null);
const router = useRouter();
const route = useRoute();
const store = useStore();

const LoginHandling = async () => {
  const button = document.querySelector('button[type="submit"]');
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/login", {
      email: form.value.email,
      password: form.value.password,
    });

    let { data } = await axios.get("http://localhost:8000/api/user");

    // storing the data
    sessionStorage.setItem("Authentication", true);
    sessionStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

    if (data.role == "admin") {
      router.push({
        name: `DashboardView`,
        query: { message: "loggedIn" },
      });
    } else {
      router.push({
        name: `${route.query.previous}`,
        query: { message: "loggedIn" },
      });
    }
  } catch (error) {
    button.disabled = false;
    if (error.response) {
      if (error.response.status == 429) {
        serverError.value = "Too many requests. Please try again later.";
        setTimeout(() => {
          serverError.value = null;
        }, 5000);
      }
      if (error.response.status != 422) {
        serverError.value = error.message;
        setTimeout(() => {
          serverError.value = null;
        }, 5000);
      } else {
        errors.value = error.response.data.errors ?? null;
      }
    }
  }
};
</script>

<style></style>
