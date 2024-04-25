<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
    style="min-height: calc(100vh - 11rem)"
  >
    <form
      method="POST"
      @submit.prevent="forgotPasswordHandler"
      class="bg-white border border-gray-900 shadow-2xl p-4 sm:p-6 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">Mot de passe Oublie</h2>
      </header>

      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2 required"
          >Email</label
        >
        <input
          id="email"
          type="email"
          v-model="email"
          class="border border-gray-600 rounded p-2 w-full"
          name="email"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
      </div>

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Envoyer un lien
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import ForgotPassword from "@/Composables/AuthenticationRequests/forgotPassword";

const email = ref("");
const button = ref("");
const errors = ref(null);

const forgotPasswordHandler = () => {
  ForgotPassword(button.value, email, errors);
};
</script>
