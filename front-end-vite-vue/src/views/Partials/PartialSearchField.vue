<template>
  <div
    class="filter p-4 pt-20 bg-white w-full sm:w-11/12 min-h-80 max-h-max absolute z-10 rounded-lg flex items-center justify-center md:justify-around flex-wrap"
  >
    <p
      class="absolute top-4 left-1/2 -translate-x-1/2 uppercase font-mono font-bold text-2xl sm:text-4xl w-max"
      style="color: #333"
    >
      {{ title }}
    </p>
    <div
      class="selects max-w-2xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pb-4 w-full sm:w-auto"
    >
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="annee" class="text-gray-600">Choisir Annee</label>
        <select
          id="annee"
          class="border border-gray-600 rounded p-2 w-full text-gray-500"
          v-model="form.annee_fabrication"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="result in Results.annee_fabrication"
            :key="result.annees"
          >
            {{ result.annees }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="marque" class="text-gray-600">Choisir Marque</label>
        <select
          id="marque"
          class="border border-gray-600 rounded p-2 w-full text-gray-500"
          v-model="form.marque_id"
          @change="marqueSelected"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="marque in Results.marqueResult"
            :key="marque.id"
            :value="marque.id"
          >
            {{ marque.nom }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="marque" class="text-gray-600">Choisir Modele</label>
        <select
          id="modele"
          class="border border-gray-600 rounded p-2 w-full text-gray-500 disabled:cursor-not-allowed"
          v-model="form.modele_id"
          :disabled="!form.marque_id"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="modele in Results.modelesResult"
            :key="modele.id"
            :value="modele.id"
          >
            {{ modele.nom }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="ville" class="text-gray-600">Choisir Ville</label>
        <select
          id="ville"
          class="border border-gray-600 rounded p-2 w-full text-gray-500"
          v-model="form.ville_id"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="ville in Results.villeResult"
            :key="ville.id"
            :value="ville.id"
          >
            {{ ville.nom }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="carburant" class="text-gray-600">Choisir Carburant</label>
        <select
          id="carburant"
          class="border border-gray-600 rounded p-2 w-full text-gray-500"
          v-model="form.carburant"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="carburant in Results.carburantResult"
            :key="carburant"
            :value="carburant"
          >
            {{ carburant }}
          </option>
        </select>
      </div>
      <div class="inputContainer flex flex-col gap-2 sm:max-w-56">
        <label for="kilometrage" class="text-gray-600"
          >Choisir Kilometrage</label
        >
        <select
          id="kilometrage"
          class="border border-gray-600 rounded p-2 w-full text-gray-500"
          v-model="form.maxKilometrage"
        >
          <option selected value="" class="text-gray-600">--Choisir--</option>
          <option
            v-for="kilometrage in Results.kilometrageResult"
            :key="kilometrage.value"
            :value="kilometrage.value"
          >
            {{ kilometrage.label }}
          </option>
        </select>
      </div>
    </div>
    <div class="inputContainer flex flex-col justify-center items-center gap-2">
      <rangeSlider
        @update-range="UpdateRangeVars"
        :maximum="parseFloat(Results.max_price)"
      ></rangeSlider>
      <button
        @click="filterDisplay"
        class="bg-red-500 hover:bg-red-800 text-white rounded py-2 px-4"
      >
        Rechercher
      </button>
    </div>
  </div>
</template>
<script setup>
import rangeSlider from "@/Components/RangeSlider.vue";
import getFromDB from "@/Composables/Getters/getFromDB";
import getPaginate from "@/Composables/Getters/getPaginate";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";

const props = defineProps(["title", "type", "getter"]);
const emits = defineEmits(["updatePage"]);

const form = ref({
  annee_fabrication: "",
  marque_id: "",
  modele_id: "",
  ville_id: "",
  carburant: "",
  maxKilometrage: "",
  min_price: 0,
  max_price: 40000,
});

const filterDisplay = () => {
  getPaginate(1, props.getter, {}, form.value).then((data) => {
    if (data) {
      emits("updatePage", data.PaginateQuery, form.value);
    }
  });
};

/**
 *
 * Fetching begins here for data in select fields
 *
 */
const Results = ref({
  annee_fabrication: [],
  marqueResult: [],
  modelesResult: [],
  villeResult: [],
  carburantResult: ["diesel", "essence", "hybride", "electrique"],
  kilometrageResult: [
    {
      label: "<= 10 000",
      value: 10000,
    },
    {
      label: "<= 20 000",
      value: 20000,
    },
    {
      label: "<= 30 000",
      value: 30000,
    },
    {
      label: "<= 40 000",
      value: 40000,
    },
    {
      label: "<= 50 000",
      value: 50000,
    },
    {
      label: "<= 100 000",
      value: 100000,
    },
    {
      label: "<= 250 000",
      value: 250000,
    },
  ],
  max_price: 0,
});
const UpdateRangeVars = (min, max) => {
  form.value.min_price = min;
  form.value.max_price = max;
};

// Fetching Marques
getFromDB(Endpoints.marque__get_all_or_add).then((response) => {
  if (response) {
    Results.value.marqueResult = response;
  }
});
// end marques
// // Fetching Modeles after selecting marque
const marqueSelected = () => {
  Results.value.modelesResult = [];
  if (form.value.marque_id) {
    getFromDB(Endpoints.modele__get_by_marque + form.value.marque_id).then(
      (response) => {
        if (response) {
          Results.value.modelesResult = response;
        }
      }
    );
  }
};
// // end Fetching Modeles

// fetching villes
getFromDB(Endpoints.ville__get_all_or_add).then((response) => {
  if (response) {
    Results.value.villeResult = response;
  }
});

// fetching annee
getFromDB(Endpoints.annonce__get_annee_fabrication).then((response) => {
  if (response) {
    Results.value.annee_fabrication = response;
  }
});
// fetch max price
if (props.type === "neuf") {
  getFromDB(Endpoints.neuf__get_max_price).then((response) => {
    if (response) {
      console.log(response.max_price);
      Results.value.max_price = response.max_price;
      form.value.max_price = response.max_price;
    }
  });
} else if (props.type === "occasion") {
  getFromDB(Endpoints.occasion__get_max_price).then((response) => {
    if (response) {
      Results.value.max_price = response.max_price;
      form.value.max_price = response.max_price;
    }
  });
} else if (props.type === "location") {
  getFromDB(Endpoints.location__get_max_price).then((response) => {
    if (response) {
      Results.value.max_price = response.max_price;
      form.value.max_price = response.max_price;
    }
  });
}
</script>
<style scoped>
.filter {
  bottom: -145%;
}
@media screen and (min-width: 640px) {
  .filter {
    bottom: -90%;
  }
}
@media screen and (min-width: 1024px) {
  .filter {
    bottom: -70%;
  }
}
@media screen and (min-width: 1128px) {
  .filter {
    bottom: -50%;
  }
}
</style>
