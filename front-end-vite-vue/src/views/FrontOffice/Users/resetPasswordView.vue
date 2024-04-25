<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
    style="min-height: calc(100vh - 11rem)"
  >
    <form
      method="POST"
      @submit.prevent="resetPasswordHandler"
      class="bg-white border border-gray-900 shadow-2xl p-4 sm:p-6 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
          Reinitialiser le mot de passe
        </h2>
      </header>

      <div class="mb-6">
        <label for="password" class="inline-block text-lg mb-2 required"
          >Mot de passe</label
        >
        <input
          id="password"
          type="password"
          v-model="passwords.password"
          class="border border-gray-600 rounded p-2 w-full"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.password">
            {{ errors.password[0] }}
          </p>
        </div>
      </div>

      <div class="mb-6">
        <label for="password2" class="inline-block text-lg mb-2 required"
          >Confirmation mot de passe</label
        >
        <input
          id="password2"
          type="password"
          v-model="passwords.password_confirmation"
          class="border border-gray-600 rounded p-2 w-full"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.password_confirmation">
            {{ errors.password_confirmation[0] }}
          </p>
        </div>
      </div>

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Reinitialiser
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import resetPassword from "@/Composables/AuthenticationRequests/resetPassword";
import { useRoute } from "vue-router";

const props = defineProps(["token"]);
const route = useRoute();

const passwords = ref({
  password: null,
  password_confirmation: null,
  token: props.token,
  email: route.query.email,
});
const button = ref("");
const errors = ref(null);

const resetPasswordHandler = () => {
  resetPassword(button.value, passwords, errors);
};
</script>
