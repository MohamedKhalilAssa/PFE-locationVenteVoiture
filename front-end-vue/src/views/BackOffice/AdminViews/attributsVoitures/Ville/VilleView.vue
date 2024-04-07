<template>
  <Table
    :columns="columns"
    :getter="Endpoints.ville__paginate"
    :deleteFrom="Endpoints.ville__get_or_update_or_delete"
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
  { name: "ID", key: "id", sortable: true },
  { name: "Nom de la ville", key: "nom", sortable: true },
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
