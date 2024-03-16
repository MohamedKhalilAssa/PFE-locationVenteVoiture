<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="marqueResult != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Les Modeles de {{ nomMarque.nom }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous la liste des Modeles de {{ nomMarque.nom }}
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
            <router-link to="/">
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
import getModeles from "@/Composables/Getters/getModeles";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const nomMarque = ref("");
const router = useRouter();

// loading the brand
getById(endpoint, props.id, serverError).then((data) => {
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
});
// loading the modeles associated with it
const { modelesResult, ErrorModele, loadModele } = getModeles();
loadModele(props.id);
</script>
