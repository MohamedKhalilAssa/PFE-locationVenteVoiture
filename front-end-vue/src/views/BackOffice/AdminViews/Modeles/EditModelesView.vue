<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="updateModele"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-lg w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Modifier un modele</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom du Modele</label
        >
        <input
          v-model="nomModele"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          name="nom"
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
          v-model="marqueVmodel"
          id="marque"
          class="border border-gray-600 rounded p-2 w-full"
          name="marque_id"
        >
          <option
            v-for="marque in marqueResult"
            :key="marque.id"
            :value="marque.id"
            :selected="marqueVmodel == marqueResult.marque_id"
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

      <div class="mb-6">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier le modele
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
import { useRouter } from "vue-router";
import getById from "@/Composables/Getters/getById";
import getMarques from "@/Composables/Getters/getMarques";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";

const errors = ref(null);
const router = useRouter();
const nomModele = ref("");
const marqueVmodel = ref("");
const button = ref(null);
const endpoint = "http://localhost:8000/api/modele/";
const serverError = ref(null);

// fetching existing modele
const props = defineProps(["id"]);

getById(endpoint, props.id, serverError).then((data) => {
  if (data) {
    nomModele.value = data.nom;
    marqueVmodel.value = data.marque_id;
  } else {
    router.push({
      name: "modelesView",
      query: {
        error: "Modele introuvable",
      },
    });
  }
});

// Fetching Marques
const { marqueResult, ErrorMarque, loadMarque } = getMarques();
loadMarque();
// end marques

// post method handling
const updateModele = async () => {
  const form = new FormData();
  form.append("nom", nomModele.value);
  form.append("marque_id", marqueVmodel.value);
  EditToDB(
    button.value,
    endpoint,
    props.id,
    form,
    router,
    "modelesView",
    errors,
    serverError
  );
};
</script>
