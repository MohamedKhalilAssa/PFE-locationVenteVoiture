<template>
  <Table
    :columns="columns"
    :getter="Endpoints.occasion__paginate_backOffice"
    :deleteFrom="Endpoints.annonce__get_or_update_or_delete"
    :actions="actions"
    titre="Occasion"
    addName="ajouterAnnonceFront"
  >
  </Table>
</template>

<script setup>
import Table from "@/Components/TableElements/Table.vue";
import Endpoints from "@/assets/JS/Endpoints";

// without actions

const columns = [
  { name: "ID", key: "id", sortable: true },
  { name: "Marque", key: "marque.nom", sortable: true },
  { name: "Modele", key: "modele.nom", sortable: true },

  { name: "Annee", key: "annee_fabrication", sortable: true },
  { name: "Ville", key: "ville.nom", sortable: true },
  { name: "Type", key: "type_annonce", capitalize: true, sortable: true },
  {
    name: "Statut",
    key: "statut_annonce",
    capitalize: true,
    sortable: true,
    isStatus: true,
  },
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
