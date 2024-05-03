<template>
  <div
    class="modal fixed top-0 left-0 flex justify-center items-center w-screen h-full bg-black bg-opacity-50"
    style="z-index: 90"
  >
    <div
      class="relative content rounded-lg bg-gray-100 max-w-xl w-11/12 sm:w-full h-full flex flex-col justify-between items-center gap-10 p-6 sm:p-12"
      style="max-height: 35rem"
    >
      <div class="icon flex justify-center flex-col items-center">
        <i class="fa-solid fa-circle-exclamation text-9xl text-orange-500"></i>
        <h3 class="text-2xl sm:text-4xl font-sans mt-2">
          Change Disponibilite
        </h3>
        <p class="font-sans text-sm sm:text-md mt-2">
          You won't be able to revert this!
        </p>
      </div>
      <div class="text h-2/3 w-full flex justify-center items-center">
        <select
          v-if="!isChangedTo"
          id="dispoChange"
          class="mx-auto block w-3/4 sm:w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="form.disponibilite"
        >
          <option value="disponible">Disponible</option>
          <option value="indisponible">Indisponible</option>
          <option :value="lastValue">{{ lastValue }}</option>
        </select>
        <div
          class="actionContainer flex flex-col gap-2 justify-center"
          v-else-if="isChangedTo == 'louer'"
        >
          <div class="field w-full flex flex-col items-center gap-2">
            <div class="inputs flex justify-between items-center">
              <label for="date_debut" class="w-24">Date debut</label>
              <input
                v-model="form.date_debut"
                id="date_debut"
                type="date"
                class="block w-44 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
            </div>
            <div class="errors" v-if="errors">
              <p class="text-red-600" v-if="errors.date_debut">
                {{ errors.date_debut[0] }}
              </p>
            </div>
          </div>
          <div class="field w-full flex flex-col items-center gap-2">
            <div class="inputs flex justify-between items-center">
              <label for="date_fin" class="w-24">Date fin</label>
              <input
                v-model="form.date_fin"
                id="date_fin"
                type="date"
                class="block w-44 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
            </div>
            <div class="errors" v-if="errors">
              <p class="text-red-600" v-if="errors.date_fin">
                {{ errors.date_fin[0] }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="buttons flex gap-4">
        <button
          v-if="!isChangedTo"
          @click="dispoChanged"
          class="w-28 bg-red-500 text-white px-6 py-2"
        >
          Confirm
        </button>
        <button
          v-if="isChangedTo"
          @click="actionHandling"
          class="w-28 bg-red-500 text-white px-6 py-2"
        >
          Confirm
        </button>
        <button
          @click="emitClosed"
          class="w-28 bg-gray-500 text-white px-6 py-2"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import Endpoints from "@/assets/JS/Endpoints";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";

const props = defineProps(["row", "type_dispo", "dispo_key"]);
const emit = defineEmits(["closed"]);
const errors = ref({
  date_debut: null,
  date_fin: null,
});
const type_dispo = props.dispo_key.split("_")[1];
const lastValue = type_dispo == "vente" ? "vendu" : "louer";
const isChangedTo = ref(false);
const form = ref({
  disponibilite: props.row[props.dispo_key],
  date_debut: new Date().toISOString().split("T")[0],
  date_fin: null,
});
const dispoChanged = async () => {
  if (form.value.disponibilite != "louer") {
    const formData = new FormData();
    formData.append("disponibilite_" + type_dispo, form.value.disponibilite);
    await EditToDB(
      null,
      Endpoints.annonce__update_disponibilite,
      props.row.id,
      formData,
      "",
      errors
    );

    if (!errors.value) emit("closed", true);
  } else if (form.value.disponibilite == "louer") {
    isChangedTo.value = "louer";
  }
};
// actionHandling for location or vente
const actionHandling = async () => {
  if (isChangedTo.value == "louer") {
    if (form.value.date_debut > form.value.date_fin) {
      errors.value.date_fin = ["Date fin invalide"];
    } else {
      const formData = new FormData();
      formData.append("disponibilite_location", "louer");
      formData.append("date_debut", form.value.date_debut);
      formData.append("date_fin", form.value.date_fin);
      await EditToDB(
        null,
        Endpoints.annonce__update_disponibilite,
        props.row.id,
        formData,
        "",
        errors
      );
      if (!errors.value) emit("closed", true);
    }
  }
};
const emitClosed = () => emit("closed");
</script>
