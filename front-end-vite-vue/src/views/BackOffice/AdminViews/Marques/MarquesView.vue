<template>
  <Table
    :columns="columns"
    :getter="Endpoints.marque__paginate"
    :deleteFrom="Endpoints.marque__get_or_update_or_delete"
    :actions="actions"
    titre="Marque"
    addName="ajouterMarque"
  />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Nom", key: "nom", sortable: true },
  { name: "Image", key: "image", isImage: true },
  { name: "actions" },
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
