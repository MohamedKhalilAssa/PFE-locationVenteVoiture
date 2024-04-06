<template>
  <Table
    :columns="columns"
    :getter="Endpoints.ModelePagination"
    :deleteFrom="Endpoints.getOrUpdateOrDeleteModele"
    :actions="actions"
    titre="Modele"
    addName="ajouterModele"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Nom du Modele", key: "nom", sortable: true },
  // {
  //   name: "ID Marque",
  //   key: "marque_id",
  //   isLink: true,
  //   toName: "detailsMarque",
  //   toID: "marque_id",
  //   sortable: true,
  // },
  {
    name: "marque.nom",
    key: "marque.nom",
    sortable: true,
    toName: "detailsMarque",
    toID: "marque.id",
    isLink: true,  },
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
