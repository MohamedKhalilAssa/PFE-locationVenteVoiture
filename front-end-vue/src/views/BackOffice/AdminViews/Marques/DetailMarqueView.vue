<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="nomMarque != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Les Modeles de {{ nomMarque }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous la liste des Modeles de {{ nomMarque }}
      </p>
    </div>
    <div
      class="border-t border-gray-200 px-4 py-5"
      v-if="modelesResult != null"
      v-for="modele in modelesResult"
      :key="modele.id"
    >
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max">
            Nom du Modele
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            <!-- :to="{ name: 'ModeleDetail', params: { id: modele.id } } -->
            <router-link :to="{ name: 'modelesView' }">
              {{ modele.nom }}
            </router-link>
          </dd>
        </div>
      </dl>
    </div>
  </div>
</template>

<script setup>
import getById from "@/Composables/Getters/getById";
import getFromDB from "@/Composables/Getters/getFromDB";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const nomMarque = ref("");
const modelesResult = ref(null);
const router = useRouter();
const store = useStore();

// loading the brand
getById(Endpoints.getOrUpdateOrDeleteMarque, props.id, store).then((data) => {
  if (data) {
    nomMarque.value = data.nom;
  } else {
    store.commit("setError", "Utilisateur introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "marquesView",
    });
  }
});
// loading the modeles associated with it

getFromDB(Endpoints.getModelesByMarque + props.id, store).then((response) => {
  if (response) {
    modelesResult.value = response;
  }
});
</script>
