<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col px-4"
  >
    <form
      @submit.prevent="ajouterMarque"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-xl w-full"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Ajouter une marque</h2>
      </header>

      <AddImageField
        @imageChanged="imageChanged"
        :errors="errors"
      ></AddImageField>
      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la Marque</label
        >
        <input
          v-model="nomMarque"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
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
          Ajouter la marque
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref, watchEffect } from "vue";
import { useRouter } from "vue-router";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";
import AddImageField from "@/Components/addImageField.vue";

const errors = ref(null);
const router = useRouter();
const store = useStore();

const nomMarque = ref("");
const imageMarque = ref(null);
const button = ref(null);

const imageChanged = (image) => {
  imageMarque.value = image;
};

// post method handling
const ajouterMarque = async () => {
  const formData = new FormData();
  formData.append("nom", nomMarque.value);
  formData.append("image", imageMarque.value);
  AddToDB(
    button.value,
    Endpoints.marque__get_all_or_add,
    formData,
    "marquesView",
    errors
  );
};
</script>
