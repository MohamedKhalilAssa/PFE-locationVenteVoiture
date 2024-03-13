<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="updateMarque"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-lg w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Modifier une marque</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la Marque</label
        >
        <input
          v-model="nomMarque"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          name="nom"
          placeholder="Exemple: Toyota..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.nom">{{ errors.nom[0] }}</p>
        </div>
      </div>

      <div class="mb-6">
        <button
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier la marque
        </button>
      </div>
    </form>
    <div
      class="errors max-w-lg text-center mx-auto mb-10 mt-10"
      v-if="serverError"
    >
      <p class="text-red-600">{{ serverError }}</p>
    </div>
  </section>
</template>
<script setup>
import { ref, watchEffect } from "vue";
import axios from "axios";
import getMarqueById from "@/Composables/Getters/getMarqueById";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const errors = ref(null);
const router = useRouter();
const nomMarque = ref("");

// fetching marque by id
const { marqueResult, ErrorMarque, loadMarque } = getMarqueById();
loadMarque(props.id).then(() => {
  nomMarque.value = marqueResult.value.nom;
});

// post method handling
const updateMarque = async () => {
  const button = document.querySelector('button[type="submit"]');
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    // Send the FormData object to the server using axios
    await axios.post("http://localhost:8000/api/marque/" + props.id, {
      nom: nomMarque.value,
    });

    router.push({ name: "marquesView" });
  } catch (error) {
    button.disabled = false;
    errors.value = error.response.data.errors;
  }
};
</script>
@/Composables/Getters/getMarqueById
