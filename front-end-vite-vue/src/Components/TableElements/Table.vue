<template>
  <TableHeader :titre="titre" :addDestination="addName">
    {{ total }}
  </TableHeader>
  <div class="bg-white relative shadow-lg sm:rounded-lg">
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
              @delete="DeleteHandler"
            ></TableContent>
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
      v-if="result.data && result.data.length > 0"
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
import { useStore } from "vuex";

const props = defineProps([
  "columns",
  "actions",
  "getter",
  "deleteFrom",
  "titre",
  "addName",
]);
const store = useStore();
let result = ref({});
let total = ref(0);
const requestParams = ref({
  sort: "none",
  sortColumn: "id",
  search: "",
  searchColumn: "nom",
});

getPaginate(
  1,
  props.getter,
  requestParams.value.sort,
  requestParams.value.sortColumn,
  requestParams.value.search,
  requestParams.value.searchColumn,
  "id"
).then((data) => {
  if (data) {
    result.value = data.PaginateQuery;
    total.value = data.total;
  }
});
// pagination
const updateResult = (data) => {
  result.value = data;
}
// handling the search form
const handlingSearch = (search, searchColumn, defaultColumn) => {
  requestParams.value.search = search;
  requestParams.value.searchColumn = searchColumn;
  getPaginate(
    1,
    props.getter,
    requestParams.value.sort,
    requestParams.value.sortColumn,
    search,
    searchColumn,
    defaultColumn
  ).then((data) => {
    if (data) {
      result.value = data.PaginateQuery;
      total.value = data.total;
    }
  });
};
// sorting

const sortingBy = (column, sort) => {
  requestParams.value.sort = sort;
  requestParams.value.sortColumn = column;
  // we ignore the search params
  getPaginate(
    1,
    props.getter,
    sort,
    column,
    requestParams.value.search,
    requestParams.value.searchColumn,
    "id"
  ).then((data) => {
    if (data) {
      result.value = data.PaginateQuery;
      total.value = data.total;
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
