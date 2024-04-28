<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="ajouterCouleur"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Ajouter une Couleur</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la couleur</label
        >
        <input
          v-model="form.nom"
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
          v-model="form.Hexadecimal"
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
          Ajouter la couleur
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { setFormData } from "@/Composables/Helpers/globalFunctions";

const errors = ref(null);

const button = ref(null);

const form = ref({
  nom: ref(""),
  Hexadecimal: ref("#000000"),
});
// post method handling
const ajouterCouleur = async () => {
  const formData = setFormData(form);
  AddToDB(
    button.value,
    Endpoints.couleur__get_all_or_add,
    formData,
    "couleursView",
    errors
  );
};
</script>
