<template>
  <Table
    :columns="columns"
    :getter="Endpoints.couleur__paginate"
    :deleteFrom="Endpoints.couleur__get_or_update_or_delete"
    :actions="actions"
    titre="Couleur"
    addName="ajouterCouleur"
  />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "la Couleur", key: "nom", sortable: true },
  { name: "HEX", key: "Hexadecimal", sortable: true, capitalize: true },
  { name: "actions" },
];
// action
const actions = [
  {
    label: "Details",
    redirectToAction: "detailsCouleur",
    toID: "id",
    addClass: "text-green-600",
  },
  {
    label: "Modifier",
    redirectToAction: "modifierCouleur",
    toID: "id",
    addClass: "text-blue-600",
  },
  { label: "Supprimer" },
];

// deleting marque
</script>
