<template>
  <div
    class="modal fixed top-0 left-0 flex justify-center items-center w-screen h-full bg-black bg-opacity-50"
    style="z-index: 90"
  >
    <div
      class="relative content bg-gray-100 max-w-xl w-full h-full flex flex-col justify-between items-center gap-10 p-12"
      style="max-height: 30rem"
    >
      <div class="icon flex justify-center flex-col items-center">
        <i class="fa-solid fa-circle-exclamation text-9xl text-orange-500"></i>
        <h3 class="text-4xl font-sans mt-2">Change Disponibilite</h3>
        <p class="font-sans mt-2">You won't be able to revert this!</p>
      </div>
      <div class="text h-2/3 w-full">
        <select
          id="dispoChange"
          class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="form.disponibilite"
        >
          <option value="disponible">Disponible</option>
          <option value="indisponible">Indisponible</option>
          <option :value="lastValue">{{ lastValue }}</option>
        </select>
      </div>
      <div class="buttons flex gap-4">
        <button
          @click="dispoChanged"
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

const type_dispo = props.dispo_key.split("_")[1];
const lastValue = type_dispo == "vente" ? "vendu" : "louer";
const isChanged = ref(false);
const form = ref({
  disponibilite: props.row[props.dispo_key],
});
console.log(props.row);
const dispoChanged = async () => {
  isChanged.value = true;
  if (form.value.disponibilite == "vendu") {
  } else if (form.value.disponibilite == "louer") {
  } else {
    const formData = new FormData();
    formData.append("disponibilite_" + type_dispo, form.value.disponibilite);
    await EditToDB(
      null,
      Endpoints.annonce__update_disponibilite,
      props.row.id,
      formData,
      ""
    );
    emit("closed", true);
  }
};
const emitClosed = () => emit("closed");
</script>
