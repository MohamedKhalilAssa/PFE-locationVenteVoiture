<template>
  <Table
    :columns="columns"
    :getter="Endpoints.userPaginate"
    :deleteFrom="Endpoints.getOrUpdateOrDeleteUser"
    :actions="actions"
    titre="Utilisateur"
    addName="ajouterUser"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id" },
  { name: "Nom", key: "nom" },
  { name: "Prenom", key: "prenom" },
  { name: "Email", key: "email" },
  { name: "Telephone", key: "telephone" },
  { name: "Role", key: "role", capitalize: true },
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
