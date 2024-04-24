<template>
  <main class="p-2 sm:p-4 md:ml-14 md:p-8 my-10">
    <div class="conditions" v-if="results">
      <div class="title flex m-6">
        <h1 class="text-2xl sm:text-3xl font-bold">{{ results["titre"] }}</h1>
      </div>
      <div class="ContentCard flex justify-center flex-wrap gap-4">
        <imageSlider
          :data="results"
          addClass="w-full max-w-47Rem h-96 h-40rem !rounded-none"
          @clicked="getImage"
        ></imageSlider>
        <div
          class="details bg-white p-4 rounded-lg w-full max-w-47Rem flex flex-col gap-y-6"
        >
          <h3
            class="relative text-lg leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-6 pb-2"
          >
            Details
          </h3>
          <div class="table">
            <div class="line mt-4 flex flex-wrap justify-between sm:border-b">
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Marque
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results.marque.nom }}
                </p>
              </div>
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Modele
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["modele"]["nom"] }}
                </p>
              </div>
            </div>
            <div class="line flex flex-wrap justify-between sm:border-b">
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Année
                </h3>
                <p class="text-black font-bold max-w-max">
                  {{ results["annee_fabrication"] }}
                </p>
              </div>
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Ville
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["ville"]["nom"] }}
                </p>
              </div>
            </div>
            <div class="line flex flex-wrap justify-between sm:border-b">
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Carburant
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["carburant"] }}
                </p>
              </div>
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Kilometrage
                </h3>
                <p class="text-black font-bold max-w-max">
                  {{ results["kilometrage"] }}
                </p>
              </div>
            </div>
            <div class="line flex flex-wrap justify-between sm:border-b">
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Etat
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["etat"] }}
                </p>
              </div>
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Type
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["type_annonce"] }}
                </p>
              </div>
            </div>
            <div class="line flex flex-wrap justify-between sm:border-b">
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Couleur
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["couleur"]["nom"] }}
                </p>
              </div>
              <div
                class="field flex gap-3 py-2 px-2 w-full sm:w-80 border-b sm:border-none"
              >
                <h3 class="font-medium text-gray-500 whitespace-nowrap w-24">
                  Propriétaire
                </h3>
                <p
                  class="text-black font-bold max-w-max lowercase first-letter:uppercase"
                >
                  {{ results["owner"]["prenom"] }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="moreDetailContainer"></div>
    </div>
  </main>
  <ImageDisplay
    v-if="images"
    :images="images"
    :index="index"
    @closed="images = null"
  ></ImageDisplay>
</template>
<style>
.max-w-47Rem {
  max-width: 47rem;
}

@media screen and (min-width: 1024px) and (max-width: 1650px) {
  .max-w-47Rem {
    max-width: 70rem;
  }
  .h-40rem {
    height: 35rem;
  }
}
</style>
<script setup>
import getById from "@/Composables/Getters/getById";
import Endpoints from "@/assets/JS/Endpoints";
import imageSlider from "@/Components/imageSlider.vue";
import ImageDisplay from "@/Components/ImageDisplay.vue";
import store from "@/store";
import router from "@/router";
import { ref } from "vue";

const props = defineProps(["id"]);
const results = ref(null);
const images = ref(null);
const index = ref();
const getImage = (image, i) => {
  images.value = image;
  index.value = i;
};
// loading the brand
getById(Endpoints.annonce__get_by_id, props.id).then((data) => {
  if (data) {
    results.value = data;
  } else {
    store.commit("setError", "annonce introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "homeView",
    });
  }
});
</script>
