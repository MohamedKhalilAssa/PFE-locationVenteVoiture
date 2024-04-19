<template>
  <div
    class="filter p-4 bg-white w-11/12 min-h-80 max-h-max absolute z-10 -bottom-3/4 sm:-bottom-1/2 rounded-lg"
  >
    <div
      class="selects max-w-2xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
    >
      <div class="inputContainer flex flex-col gap-2 max-w-56">
        <label for="annee" class="text-gray-600">Choisir Annee</label>
        <select
          name="annee_fabrication"
          id="annee"
          class="border border-gray-600 rounded p-2 w-full text-gray-600"
        >
          <option selected :value="null" class="text-gray-600">
            --Choisir Annee--
          </option>
          <option v-for="year in Results.annee_fabrication" :key="year">
            {{ year }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 max-w-56">
        <label for="marque" class="text-gray-600">Choisir Marque</label>
        <select
          name="marque_id"
          id="marque"
          class="border border-gray-600 rounded p-2 w-full text-gray-600"
          v-model="form.marque_id"
        >
          <option selected value="" class="text-gray-600">
            --Choisir La Marque--
          </option>
          <option
            v-for="marque in Results.marqueResult"
            :key="marque"
            :value="marque.id"
          >
            {{ marque.nom }}
          </option>
        </select>
      </div>
      
    </div>
  </div>
</template>
<script setup>
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";

// fetching begins here
const Results = ref({
  annee_fabrication: [],
  marqueResult: [],
  modelesResult: [],
  couleurResult: [],
  villeResult: [],
});

const form = ref({
  annee_fabrication: "",
  marque_id: "",
  modele_id: "",
  couleur_id: "",
  ville_id: "",
});

// Fetching Marques
getFromDB(Endpoints.marque__get_all_or_add).then((response) => {
  if (response) {
    Results.value.marqueResult = response;
  }
});
// end marques

// on mounted set years since 1970
for (let i = 1970; i <= new Date().getFullYear(); i++) {
  Results.value.annee_fabrication.push(i);
}
// end years
</script>
