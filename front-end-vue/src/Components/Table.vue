<script setup>
import DeleteFromDB from "@/Composables/CRUDRequests/DeleteFromDB";
import getPaginate from "@/Composables/Getters/getPaginate";
import TableHeader from "@/Components/TableElements/TableHeader.vue";
import SearchField from "@/Components/TableElements/SearchField.vue";
import TablePagination from "@/Components/TableElements/TablePagination.vue";
import ActionsTable from "@/Components/TableElements/ActionsTable.vue";
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

getPaginate(1, props.getter).then((data) => {
  result.value = data.PaginateQuery;
  total.value = data.total;
});

// handling the search form
const handlingSearch = (search,selectedColumn) => {
  getPaginate(1, props.getter, search,selectedColumn).then((data) => {
    result.value = data.PaginateQuery;
    total.value = data.total;
  });
};
const pagination = (e, page) => {
  console.log(e);
  const button = e.target;
  button.classList.add("!cursor-progress");
  if (page !== null) {
    const number = page.split("page=")[1];
    getPaginate(number, props.getter).then((data) => {
      result.value = data.PaginateQuery;
      button.classList.remove("!cursor-progress");
    });
  }
};
const DeleteHandler = (id) => {
  DeleteFromDB(
    props.deleteFrom,
    id,
    getPaginate,
    props.getter,
    result.value.current_page,
    result,
    total,
    store
  );
};
</script>
<template>
  <TableHeader :titre="titre" :addDestination="addName">
    {{ total }}
  </TableHeader>
  <div class="bg-white relative shadow-lg sm:rounded-lg">
    <SearchField :columns="columns" @search="handlingSearch" addClass="py-4"></SearchField>

    <div
      class="tableauContainer overflow-auto lg:!max-h-full"
      v-if="result.data && result.data.length > 0"
      style="max-height: 65vh"
    >
      <table class="w-full text-sm text-center text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
          <tr>
            <TableColumns :columns="columns"></TableColumns>
          </tr>
        </thead>
        <tbody>
          <tr
            class="bg-white border-b"
            v-for="row in result.data"
            :key="row.id"
          >
            <TableContent :columns="columns" :row="row"></TableContent>
            <ActionsTable
              :actions="actions"
              :row="row"
              @delete="DeleteHandler"
            ></ActionsTable>
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
      @pagination="pagination"
      v-if="result.data && result.data.length > 0"
      addClass="py-4"
    ></TablePagination>
  </div>
</template>
