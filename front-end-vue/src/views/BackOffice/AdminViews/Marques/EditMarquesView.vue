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
          >Nom de la marque</label
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

      <div class="mb-6 flex justify-center items-center">
        <button
          ref="button"
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
import { ref } from "vue";
import getById from "@/Composables/Getters/getById";
import { useRouter } from "vue-router";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";

const props = defineProps(["id"]);
const errors = ref(null);
const router = useRouter();
const store = useStore();
const nomMarque = ref("");
const button = ref(null);
const serverError = ref(null);

// fetching marque by id
getById(Endpoints.getOrUpdateOrDeleteMarque, props.id, serverError).then(
  (data) => {
    if (data) {
      nomMarque.value = data.nom;
    } else {
      router.push({
        name: "marquesView",
        query: {
          error: "Marque introuvable",
        },
      });
    }
  }
);

// post method handling
const updateMarque = async () => {
  const form = new FormData();
  form.append("nom", nomMarque.value);
  EditToDB(
    button.value,
    Endpoints.getOrUpdateOrDeleteMarque,
    props.id,
    form,
    router,
    store,
    "marquesView",
    errors,
    serverError
  );
};
</script>
