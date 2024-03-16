<template>
  <button
    class="bg-green-700 text-white rounded py-2 px-4 mx-auto my-6 hover:bg-green-800 duration-75 disabled:opacity-70 disabled:cursor-progress"
  >
    <router-link :to="{ name: 'ajouterMarque' }">
      Ajouter une Marque+
    </router-link>
  </button>
  <Table
    :columns="columns"
    :getter="getMarquesPaginate"
    :deleteFrom="deletingEndpoint"
    :actions="actions"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import getMarquesPaginate from "@/Composables/Getters/getMarquesPaginate";

// without actions
const columns = [
  { name: "ID", key: "id" },
  { name: "Nom de la Marque", key: "nom" },
];
// action
const actions = [
  {
    label: "Details",
    redirectToAction: "detailsMarque",
    toID: "id",
    addClass: "text-green-600",
  },
  {
    label: "Modifier",
    redirectToAction: "modifierMarque",
    addClass: "text-blue-600",
    toID: "id",
  },
  { label: "Supprimer" },
];

// deleting marque
const deletingEndpoint = "http://localhost:8000/api/marque/";
</script>
