<template>
  <div class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto" v-if="marqueResult != null">
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Les Modeles de {{ marqueResult.nom }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous la liste des Modeles de {{ marqueResult.nom }}
      </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5" v-if="modelesResult != null" v-for="modele in modelesResult"
      :key="modele.id">
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
import getMarqueById from "@/Composables/Getters/getMarqueById";
import getModeles from "@/Composables/Getters/getModeles";
import { watchEffect } from "vue";

const props = defineProps(["id"]);
// loading the brand
const { marqueResult, ErrorMarque, loadMarque } = getMarqueById();
loadMarque(props.id);
// loading the modeles associated with it
const { modelesResult, ErrorModele, loadModele } = getModeles();
loadModele(props.id);
</script>
@/Composables/Getters/getMarqueById@/Composables/Getters/getModeles
