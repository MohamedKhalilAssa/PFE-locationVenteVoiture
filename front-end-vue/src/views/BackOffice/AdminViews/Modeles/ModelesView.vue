<template>
  <button
    class="bg-green-700 text-white rounded py-2 px-4 mx-auto my-6 hover:bg-green-800 duration-75 disabled:opacity-70 disabled:cursor-progress"
  >
    <router-link :to="{ name: 'ajouterModele' }">
      Ajouter un Modele +
    </router-link>
  </button>
  <Table
    :columns="columns"
    :getter="Endpoints.ModelePagination"
    :deleteFrom="Endpoints.getOrUpdateOrDeleteModele"
    :actions="actions"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id" },
  { name: "Nom du Modele", key: "nom" },
  {
    name: "ID Marque",
    key: "marque_id",
    isLink: true,
    toName: "detailsMarque",
    toID: "marque_id",
  },
];
// action
const actions = [
  {
    label: "Modifier",
    redirectToAction: "modifierModele",
    toID: "id",
    addClass: "text-blue-600",
  },
  { label: "Supprimer" },
];
</script>
