<template>
  <Table :columns="columns" :getter="Endpoints.user__paginate" :deleteFrom="Endpoints.user__get_or_update_or_delete"
    :actions="actions" titre="Utilisateur" addName="ajouterUser" />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions

const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Nom", key: "nom", sortable: true },
  { name: "Prenom", key: "prenom", sortable: true },
  { name: "Email", key: "email", sortable: true },
  // { name: "Telephone", key: "telephone" },
  { name: "Role", key: "role", capitalize: true, sortable: true },
  { name: "Status", key: "status", capitalize: true, sortable: true },
  { name: "actions" },
];
// action
const actions = [
  {
    label: "Details",
    redirectToAction: "detailsUser",
    toID: "id",
    addClass: "text-green-600",
  },
  {
    label: "Modifier",
    redirectToAction: "modifierUser",
    toID: "id",
    addClass: "text-blue-600",
  },
  { label: "Supprimer" },
];
</script>
