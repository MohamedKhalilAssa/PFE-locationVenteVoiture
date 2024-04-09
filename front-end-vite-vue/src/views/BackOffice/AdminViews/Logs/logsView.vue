<template>
  <Table
    :columns="columns"
    :getter="Endpoints.analytics__get_paginate"
    titre="Log"
    :actions="actions"
  />
</template>

<script setup>
import Table from "@/Components/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions
const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "IP Address", key: "ip_address", sortable: true },
  {
    name: "User",
    key: "user_id",
    isLink: true,
    toID: "user_id",
    toName: "detailsUser",
    sortable: true,
  },

  { name: "Activity", key: "action", sortable: true },
  { name: "actions" },
];
// action
const actions = [
  {
    label: "Details",
    redirectToAction: "detailsLogs",
    toID: "id",
    addClass: "text-green-600",
  },
];
// deleting marque
</script>
