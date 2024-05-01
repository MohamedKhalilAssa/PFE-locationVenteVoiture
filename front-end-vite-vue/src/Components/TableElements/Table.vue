<template>
  <TableHeader :titre="titre" :addDestination="addName" v-if="!noHeader">
    {{ total }}
  </TableHeader>
  <div class="bg-white relative shadow-lg sm:rounded-lg" :class="customClass">
    <SearchField
      :columns="columns"
      @search="handlingSearch"
      addClass="py-4"
    ></SearchField>

    <div
      class="tableauContainer overflow-auto lg:!max-h-full"
      v-if="result.data && result.data.length > 0"
      style="max-height: 65vh"
    >
      <table class="w-full text-sm text-center text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
          <tr>
            <TableColumns :columns="columns" @sort="sortingBy"></TableColumns>
          </tr>
        </thead>
        <tbody>
          <tr
            class="bg-white border-b"
            v-for="row in result.data"
            :key="row.id"
          >
            <TableContent
              :columns="columns"
              :row="row"
              :actions="actions"
              @ChangeStatus="ChangeStatusHandler"
              @delete="DeleteHandler"
              @ChangeDisponibility="ChangeDisponibilityHandler"
            >
            </TableContent>
          </tr>
        </tbody>
      </table>
    </div>
    <div
      class="bg-white relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full p-12 flex justify-center items-center"
      style="max-height: 75vh"
      v-else
    >
      <p class="font-serif text-3xl">Aucune information a afficher</p>
    </div>
    <TablePagination
      :result="result"
      :requestParams="requestParams"
      :getter="getter"
      @updateResult="updateResult"
      v-if="result.data && result.last_page > 1"
      addClass="py-4"
    ></TablePagination>
  </div>
</template>

<script setup>
import DeleteFromDB from "@/Composables/CRUDRequests/DeleteFromDB";
import getPaginate from "@/Composables/Getters/getPaginate";
import TableHeader from "@/Components/TableElements/TableHeader.vue";
import SearchField from "@/Components/TableElements/SearchField.vue";
import TablePagination from "@/Components/Pagination.vue";
import TableContent from "@/Components/TableElements/TableContent.vue";
import TableColumns from "@/Components/TableElements/TableColumns.vue";
import { ref } from "vue";
import Swal from "sweetalert2";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import Endpoints from "@/assets/JS/Endpoints";

const props = defineProps([
  "columns",
  "actions",
  "getter",
  "deleteFrom",
  "titre",
  "addName",
  "noHeader",
  "customClass",
]);
let result = ref({});
let total = ref(0);
const requestParams = ref({
  sort: "none",
  sortColumn: "id",
  search: "",
  searchColumn: "nom",
  defaultColumn: "id",
});

const fetching = () => {
  getPaginate(1, props.getter, requestParams.value).then((data) => {
    if (data) {
      result.value = data.PaginateQuery;
      total.value = result.value.total;
    }
  });
};
fetching();
// pagination
const updateResult = (data) => {
  result.value = data;
};
// handling the search form
const handlingSearch = (search, searchColumn, defaultColumn) => {
  requestParams.value.search = search;
  requestParams.value.searchColumn = searchColumn;
  requestParams.value.defaultColumn = defaultColumn;
  fetching();
};
// sorting

const sortingBy = (column, sort) => {
  requestParams.value.sort = sort;
  requestParams.value.sortColumn = column;
  // we ignore the search params
  fetching();
};
// ChangeStatusHandler
const ChangeStatusHandler = (row, key) => {
  Swal.fire({
    title: "Change status",
    html: `<select id="statusChange"  class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option ${
      row[key] === "onhold" ? "selected" : ""
    } value="onhold">On Hold</option>
    <option  ${
      row[key] === "approved" ? "selected" : ""
    } value="approved">Approved</option>
    <option  ${
      row[key] === "disabled" ? "selected" : ""
    } value="disabled">Disabled</option>
  </select>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, change it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const status = document.querySelector("#statusChange").value;
      const form = new FormData();
      form.append("statut_annonce", status);
      EditToDB(null, Endpoints.annonce__update_status, row.id, form, "");
      fetching();
    }
  });
};
// ChangeStatusHandler
const ChangeDisponibilityHandler = (row, key) => {
  const type = key.split("_")[1];
  const value = type == "vente" ? "vendu" : "louer";
  Swal.fire({
    title: "Change disponibilite",
    html: `<select id="dispoChange"  class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option ${
      row[key] === "disponible" ? "selected" : ""
    } value="disponible">Disponible</option>
    <option  ${
      row[key] === "indisponible" ? "selected" : ""
    } value="indisponible">Indisponible</option>
    <option  ${
      row[key] === "vendu" || row[key] === "louer" ? "selected" : ""
    } value="${value}">${value}</option>
  </select>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, change it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const disponibilite = document.querySelector("#dispoChange").value;
      const form = new FormData();
      form.append("disponibilite_" + type, disponibilite);
      console.log(disponibilite);
      EditToDB(null, Endpoints.annonce__update_disponibilite, row.id, form, "");
      fetching();
    }
  });
};
// deleting
const DeleteHandler = (id) => {
  DeleteFromDB(
    props.deleteFrom,
    id,
    getPaginate,
    props.getter,
    result.value.current_page,
    result,
    total
  );
};
</script>
