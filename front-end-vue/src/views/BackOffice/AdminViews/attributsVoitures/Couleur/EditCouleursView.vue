<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="updateCouleur"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Modifier une Couleur</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la couleur</label
        >
        <input
          v-model="nomCouleur"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: Noir..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.nom">{{ errors.nom[0] }}</p>
        </div>
      </div>
      <div class="mb-6">
        <label for="couleur" class="inline-block text-lg mb-2 required"
          >Le Hexadecimal / La couleur</label
        >
        <input
          v-model="hex"
          @change="validateHex"
          id="couleur"
          type="color"
          class="border border-gray-600 rounded px-2 py-1 w-full h-12"
          placeholder="Exemple: ..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.Hexadecimal">
            {{ errors.Hexadecimal[0] }}
          </p>
        </div>
      </div>
      <div class="mb-4 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier la couleur
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import getById from "@/Composables/Getters/getById";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";

const errors = ref(null);
const nomVille = ref("");
const button = ref(null);
// variables VMODEL
const nomCouleur = ref("");
const hex = ref("#000000");

// fetching existing modele
const props = defineProps(["id"]);

getById(Endpoints.couleur__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    nomCouleur.value = data.nom;
    hex.value = data.Hexadecimal;
  } else {
    store.commit("setError", "Couleur introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "couleursView",
    });
  }
});
// post method handling
const updateCouleur = async () => {
  const form = new FormData();
  form.append("nom", nomCouleur.value);
  form.append("Hexadecimal", hex.value);
  EditToDB(
    button.value,
    Endpoints.couleur__get_or_update_or_delete,
    props.id,
    form,
    "couleursView",
    errors
  );
};
</script>
