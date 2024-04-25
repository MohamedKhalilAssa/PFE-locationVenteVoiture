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
      <div class="moreDetailContainer mt-7 flex flex-wrap justify-center gap-4">
        <div class="part1 bg-white rounded-lg max-w-70Rem p-4 w-full">
          <div class="description flex flex-col gap-y-2">
            <h3
              class="relative text-lg leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-6 pb-2"
            >
              Description
            </h3>
            <p class="text-black font-bold">
              {{ results["description"] }}
            </p>
            <div class="price">
              <h3
                class="relative text-lg leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-6 pb-2"
              >
                Prix
              </h3>
              <p
                class="text-black font-bold"
                v-if="results['type_annonce'] == 'location'"
              >
                <span class="text-gray-500">Location en DHS/Jour: </span>
                {{ parseInt(results["prix_location"]) }}
              </p>
              <p class="text-black font-bold" v-else>
                <span class="text-gray-500">Prix en DHS: </span>
                {{ parseInt(results["prix_vente"]) }}
              </p>
            </div>
          </div>
          <div class="options flex flex-col gap-y-2 mt-3 w-full">
            <h3
              class="relative text-lg leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-6 pb-2"
            >
              Options
            </h3>
            <div
              class="container flex flex-wrap !gap-y-2 items-center options mt-2"
            >
              <div
                class="option flex items-center space-x-2"
                v-for="option in options"
                :key="option"
              >
                <i class="fa-solid fa-check"></i>
                <label for="option1" class="ml-2">{{ option }}</label>
              </div>
            </div>
          </div>
        </div>
        <div class="part2 bg-white rounded-lg max-w-47Rem p-4 w-full">
          <h3
            class="relative text-lg leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-6 pb-2"
          >
            Contact
          </h3>
          <div
            class="contact flex flex-col gap-y-2 h-full pb-8 justify-between"
          >
            <div class="text">
              <p class="text-black font-bold">
                <span class="text-gray-500 w-24 inline-block">Email: </span
                >{{ results["owner"]["email"] }}
              </p>
              <p class="text-black font-bold">
                <span class="text-gray-500 w-24 inline-block">Telephone: </span
                >{{ results["owner"]["telephone"] }}
              </p>
            </div>
            <div
              class="buttons w-full flex items-center justify-center gap-4 mt-6"
            >
              <a
                :href="`mailto:${results['owner']['email']}`"
                class="flex items-center gap-2 bg-transparent border border-black text-black hover:bg-red-500 hover:border-red-500 hover:text-white duration-300 transition-all py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              >
                <i class="fa-regular text-xl fa-envelope"></i>
                Send Email
              </a>
              <a
                class="whatsapp"
                :href="`https://wa.me/+212${results['owner']['telephone']}`"
                ><i class="fa-brands text-xl fa-whatsapp pr-2"></i>Whatsapp
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <ImageDisplay
    v-if="images"
    :images="images"
    :index="index"
    @closed="closedImage"
  ></ImageDisplay>
</template>
<style>
a.whatsapp {
  text-decoration: none;
  background-color: green;
  color: white;
  font-size: 1.2rem;
  padding: 10px 15px;
  border-radius: 10px;
}
a.whatsapp:hover {
  background-color: rgb(10, 95, 10);
}
.max-w-47Rem {
  max-width: 47rem;
}
.max-w-70Rem {
  max-width: 70rem;
}
.part2.max-w-47Rem {
  max-width: 24rem;
}
.options {
  gap: 3%;
}

.option {
  width: calc(94% / 3);
}
@media screen and (min-width: 1024px) and (max-width: 1650px) {
  .max-w-47Rem,
  .part2.max-w-47Rem {
    max-width: 70rem;
  }
  .h-40rem {
    height: 35rem;
  }
}
@media screen and (max-width: 1024px) {
  .max-w-70Rem,
  .part2.max-w-47Rem {
    max-width: 47rem;
  }
}
@media screen and (max-width: 568px) {
  .option {
    width: 100%;
    margin-bottom: 0.4rem;
  }

  .option input {
    width: 1.1rem;
    height: 1.1rem;
  }

  .option label {
    font-size: 1.2rem;
    padding-bottom: 3px;
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
import { ref, onMounted, computed } from "vue";

onMounted(() => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

const props = defineProps(["id"]);
const results = ref(null);
const images = ref(null);
const index = ref();
// options computing

const options = computed(() => {
  return JSON.parse(results.value["options"]);
});

// image handling
const getImage = (image, i) => {
  images.value = image;
  index.value = i;
  document.body.classList.add("!overflow-hidden");
};
const closedImage = () => {
  images.value = null;
  document.body.classList.remove("!overflow-hidden");
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
