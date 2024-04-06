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

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier le modele
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref, watchEffect } from "vue";
import { useRouter } from "vue-router";
import getById from "@/Composables/Getters/getById";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";

const errors = ref(null);
const router = useRouter();
const store = useStore();
const nomModele = ref("");
const marqueVmodel = ref("");
const button = ref(null);

// fetching existing modele
const props = defineProps(["id"]);

getById(Endpoints.getOrUpdateOrDeleteModele, props.id).then((data) => {
  if (data) {
    nomModele.value = data.nom;
    marqueVmodel.value = data.marque_id;
  } else {
    store.commit("setError", "Modeles introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "modelesView",
    });
  }
});

// Fetching Marques
const marqueResult = ref([]);
getFromDB(Endpoints.getAllOrAddMarque).then((response) => {
  if (response) {
    marqueResult.value = response;
  }
});
// end marques

// post method handling
const updateModele = async () => {
  const form = new FormData();
  form.append("nom", nomModele.value);
  form.append("marque_id", marqueVmodel.value);
  EditToDB(
    button.value,
    Endpoints.getOrUpdateOrDeleteModele,
    props.id,
    form,
    "modelesView",
    errors
  );
};
</script>
