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
      <AddImageField
        @imageChanged="imageChanged"
        :imageLinkFromParent="form.image"
        :errors="errors"
      ></AddImageField>
      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Nom de la marque</label
        >
        <input
          v-model="form.nom"
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
          Modifier la marque
        </button>
      </div>
    </form>
  </section>
</template>
<script setup>
import { ref } from "vue";
import getById from "@/Composables/Getters/getById";
import { useRouter } from "vue-router";
import { setForm, setFormData } from "@/Composables/Helpers/globalFunctions";

import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";
import AddImageField from "@/Components/addImageField.vue";

const props = defineProps(["id"]);
const errors = ref(null);
const router = useRouter();
const store = useStore();
const form = ref({
  nom: "",
  image: null,
});
const button = ref(null);

const imageChanged = (image) => {
  form.value.image = image;
};

// fetching marque by id
getById(Endpoints.marque__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    setForm(form, data);
  } else {
    store.commit("setError", "Marque introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "marquesView",
    });
  }
});

// post method handling
const updateMarque = async () => {
  const formData = setFormData(form);
  EditToDB(
    button.value,
    Endpoints.marque__get_or_update_or_delete,
    props.id,
    formData,
    "marquesView",
    errors
  );
};
</script>
