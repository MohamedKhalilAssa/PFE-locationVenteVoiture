<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="marqueResult != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Les Modeles de {{ marqueResult.nom }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous la liste des Modeles de {{ marqueResult.nom }}
      </p>
    </div>
    <div class="flex items-center px-4 py-5 gap-8">
      <dt class="text-sm font-medium text-gray-500 min-w-max w-32">
        Logo de la marque
      </dt>
      <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
        <img
          :src="Endpoints.getStoragePath + marqueResult.image"
          alt="logo"
          class="h-16 w-16"
        />
      </dd>
    </div>
    <div
      class="border-t border-gray-200 px-4 py-5"
      v-if="modelesResult != null"
      v-for="modele in modelesResult"
      :key="modele.id"
    >
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-32">
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
const marqueResult = ref("");
const modelesResult = ref(null);
const router = useRouter();
const store = useStore();

// loading the brand
getById(Endpoints.marque__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    marqueResult.value = data;
  } else {
    store.commit("setError", "Marque introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "marquesView",
    });
  }
});
// loading the modeles associated with it

getFromDB(Endpoints.modele__get_by_marque + props.id).then((response) => {
  if (response) {
    modelesResult.value = response;
  } else {
    store.commit("setError", "Marque introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "marquesView",
    });
  }
});
</script>
