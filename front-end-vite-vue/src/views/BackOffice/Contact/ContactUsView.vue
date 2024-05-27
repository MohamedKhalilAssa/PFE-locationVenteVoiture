<template>
  <Table
    :columns="columns"
    :getter="Endpoints.contact__paginate"
    :deleteFrom="Endpoints.contact__get_or_update_or_delete"
    :actions="actions"
    titre="Contact"
  />
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions

const columns = [
  { name: "ID", key: "id", sortable: true },
  {
    name: "User ID",
    key: "user_id",
    isLink: true,
    toName: "detailsUser",
    toID: "user_id",
    sortable: true,
  },
  { name: "Full Name", key: "full_name", sortable: true },
  { name: "Email", key: "email", sortable: true },
  { name: "Objet", key: "object", capitalize: true, sortable: true },
  { name: "actions" },
];
// action
const actions = [
  {
    label: "Details",
    redirectToAction: "detailsContactUs",
    toID: "id",
    addClass: "text-green-600",
  },

  { label: "Supprimer" },
];
</script>
