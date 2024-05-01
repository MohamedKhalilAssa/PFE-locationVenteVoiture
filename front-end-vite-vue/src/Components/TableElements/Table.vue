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
import changeDisponibility from "@/Composables/Custom/changeDisponibility";
import changeStatus from "@/Composables/Custom/changeStatus";

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
const ChangeStatusHandler = async (row, key) => {
  await changeStatus(row, key);
  fetching();
};
// ChangeStatusHandler
const ChangeDisponibilityHandler = async (row, key) => {
  const type = key.split("_")[1];
  const value = type == "vente" ? "vendu" : "louer";
  await changeDisponibility(row, key, value, type);
  fetching();
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
