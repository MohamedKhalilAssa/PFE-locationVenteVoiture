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
    getter="http://localhost:8000/api/modele/pagination?page="
    :deleteFrom="deletingEndpoint"
    :actions="actions"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";

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
    label: "Details",
    redirectToAction: "detailsMarque",
    toID: "marque_id",
    addClass: "text-green-600",
  },
  {
    label: "Modifier",
    redirectToAction: "modifierModele",
    toID: "id",
    addClass: "text-blue-600",
  },
  { label: "Supprimer" },
];

// deleting marque
const deletingEndpoint = "http://localhost:8000/api/modele/";
</script>
