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
            <a>

              {{ modele.nom }}
            </a>
          </dd>
        </div>
      </dl>
    </div>
    <!-- <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Email address</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            johndoe@example.com
          </dd>
        </div>
        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Phone number</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            (123) 456-7890
          </dd>
        </div>
        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Address</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            123 Main St<br />
            Anytown, USA 12345
          </dd>
        </div> -->
    <!-- </dl> -->
  </div>
  <!-- </div> -->
</template>

<script setup>
import getMarqueById from "@/Composables/getMarqueById";
import getModeles from "@/Composables/getModeles";
import { watchEffect } from "vue";

const props = defineProps(["id"]);
// loading the brand
const { marqueResult, ErrorMarque, loadMarque } = getMarqueById();
loadMarque(props.id);
// loading the modeles associated with it
const { modelesResult, ErrorModele, loadModele } = getModeles();
loadModele(props.id);
watchEffect(() => {
  console.log(modelesResult.value, props.id);
});
</script>
