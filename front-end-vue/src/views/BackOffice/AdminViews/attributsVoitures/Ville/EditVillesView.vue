<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="updateVille"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-lg w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Modifier une ville</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la ville</label
        >
        <input
          v-model="nomVille"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          name="nom"
          placeholder="Exemple: Casablanca..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.nom">{{ errors.nom[0] }}</p>
        </div>
      </div>

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier la ville
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

// fetching existing modele
const props = defineProps(["id"]);

getById(Endpoints.ville__get_or_update_or_delete, props.id).then((data) => {
   if (data) {
    nomVille.value = data.nom;
  } else {
    store.commit("setError", "Ville introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "villesView",
    });
  }
});
// post method handling
const updateVille = async () => {
  const form = new FormData();
  form.append("nom", nomVille.value);
  EditToDB(
    button.value,
    Endpoints.ville__get_or_update_or_delete,
    props.id,
    form,
    "villesView",
    errors,
  );
};
</script>
