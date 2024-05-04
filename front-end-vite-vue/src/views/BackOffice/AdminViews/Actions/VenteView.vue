<template>
  <Table
    :columns="columns"
    :getter="Endpoints.traitement_vente__paginate"
    :deleteFrom="Endpoints.traitement_vente__delete"
    titre="Vente"
    :actions="actions"
  />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  {
    name: "Annonce ID",
    key: "voiture_id",
    isLink: true,
    toID: "voiture_id",
    toName: "detailsAnnonceFront",
    sortable: true,
  },

  { name: "Prix", key: "prix_vente", sortable: true },
  { name: "Date Vente", key: "created_at", sortable: true },
  { name: "actions" },
];
const actions = [
  {
    label: "Supprimer",
  },
];
// deleting marque
</script>
