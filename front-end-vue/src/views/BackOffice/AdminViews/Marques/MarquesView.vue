<template>
  <Table
    :columns="columns"
    :getter="Endpoints.MarquePagination"
    :deleteFrom="Endpoints.getOrUpdateOrDeleteMarque"
    :actions="actions"
    titre="Marque"
    addName="ajouterMarque"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Nom de la Marque", key: "nom", sortable: true },
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
</script>
