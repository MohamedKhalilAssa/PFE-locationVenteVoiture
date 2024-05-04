<template>
  <Table
    :columns="columns"
    :getter="Endpoints.traitement_location__paginate"
    :deleteFrom="Endpoints.traitement_location__delete"
    titre="Location"
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

  { name: "Date Debut", key: "date_debut", sortable: true },
  { name: "Date Fin", key: "date_fin", sortable: true },
  { name: "Prix Unitaire", key: "prix_location", sortable: true },
  { name: "Prix Total", key: "prix_total", sortable: true },
  { name: "actions" },
];
const actions = [
  {
    label: "Supprimer",
  },
];
// deleting marque
</script>
