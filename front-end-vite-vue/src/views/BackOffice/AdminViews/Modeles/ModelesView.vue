<template>
  <Table
    :columns="columns"
    :getter="Endpoints.modele__paginate"
    :deleteFrom="Endpoints.modele__get_or_update_or_delete"
    :actions="actions"
    titre="Modele"
    addName="ajouterModele"
  />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Nom du Modele", key: "nom", sortable: true },
  {
    name: "Nom de la Marque",
    key: "marque.nom",
    sortable: true,
    toName: "detailsMarque",
    toID: "marque_id",
    isLink: true,
  },
  { name: "actions" },
  // {
  //   name: "ID Marque",
  //   key: "marque_id",
  //   isLink: true,
  //   toName: "detailsMarque",
  //   toID: "marque_id",
  //   sortable: true,
  // },
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
