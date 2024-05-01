<template>
  <main class="p-2 sm:p-4 md:ml-12 md:p-8 my-10 flex justify-center">
    <div
      class="content p-4 mt-14 bg-white rounded-lg w-full min-h-96 shadow-lg"
    >
      <div class="header w-full min-h-16">
        <h3
          class="relative text-2xl mb-6 sm:text-3xl leading-6 font-medium tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap block after:border-b-4 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-8 pb-2"
        >
          Mes Annonces
        </h3>
      </div>
      <Table
        :columns="columns"
        :getter="Endpoints.annonce__get_user_annonces"
        :deleteFrom="Endpoints.annonce__get_or_update_or_delete"
        :actions="actions"
        titre="Neuf"
        addName="ajouterAnnonceFront"
        :noHeader="true"
        customClass="w-full !shadow-none"
      >
      </Table>
    </div>
  </main>
</template>

<script setup>
import Endpoints from "@/assets/JS/Endpoints";
import Table from "@/Components/TableElements/Table.vue";

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
    redirectToAction: "detailsAnnonceFront",
    toID: "id",
    addClass: "text-green-600",
    hasIcon: "fa-solid fa-circle-info",
  },
  {
    label: "Modifier",
    redirectToAction: "editAnnonceFront",
    toID: "id",
    addClass: "text-blue-600",
    hasIcon: "fa-solid fa-pen-to-square",
  },

  { label: "Supprimer", hasIcon: true },
];
</script>
