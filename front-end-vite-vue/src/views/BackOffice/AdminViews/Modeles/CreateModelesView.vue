<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="ajouterModele"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Ajouter un modele</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom du Modele</label
        >
        <input
          v-model="form.nom"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: Corolla..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.nom">{{ errors.nom[0] }}</p>
        </div>
      </div>
      <div class="mb-6">
        <label for="marque" class="inline-block text-lg mb-2 required"
          >Marque</label
        >
        <select
          v-model="form.marque_id"
          id="marque"
          class="border border-gray-600 rounded p-2 w-full"
        >
          <option selected value="">Choisir la marque</option>
          <option
            v-for="marque in marqueResult"
            :key="marque.id"
            :value="marque.id"
          >
            {{ marque.nom }}
          </option>
        </select>

        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.marque_id">
            {{ errors.marque_id[0] }}
          </p>
        </div>
      </div>

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Ajouter le modele
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints.js";
import { useStore } from "vuex";
import { setFormData } from "@/Composables/Helpers/globalFunctions";

const errors = ref(null);
const store = useStore();
const form = ref({
  nom: "",
  marque_id: "",
});
const button = ref(null);
const router = useRouter();

// Fetching Marques

const marqueResult = ref([]);
getFromDB(Endpoints.marque__get_all_or_add).then((response) => {
  if (response) {
    marqueResult.value = response;
  } else {
    store.commit("setError", "Modele introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "modelesView",
    });
  }
});
// end marques

// post method handling
const ajouterModele = async () => {
  const formData = setFormData(form);
  AddToDB(
    button.value,
    Endpoints.modele__get_all_or_add,
    formData,
    "modelesView",
    errors
  );
};
</script>
