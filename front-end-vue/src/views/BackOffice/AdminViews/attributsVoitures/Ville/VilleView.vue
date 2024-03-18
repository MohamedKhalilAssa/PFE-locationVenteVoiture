<template>
  <Table
    :columns="columns"
    :getter="Endpoints.VillePagination"
    :deleteFrom="Endpoints.getOrUpdateOrDeleteVille"
    :actions="actions"
    titre="Ville"
    addName="ajouterVille"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id" },
  { name: "Nom de la ville", key: "nom" },
];
// action
const actions = [
  {
    label: "Modifier",
    redirectToAction: "modifierVille",
    toID: "id",
    addClass: "text-blue-600",
  },
  { label: "Supprimer" },
];

// deleting marque
</script>
