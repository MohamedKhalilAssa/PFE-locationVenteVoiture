<script setup>
import DeleteFromDB from "@/Composables/CRUDRequests/DeleteFromDB";
import getPaginate from "@/Composables/Getters/getPaginate";
import TableHeader from "@/Components/TableHeader.vue";

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
const search = ref(null);

getPaginate(1, props.getter).then((data) => {
  result.value = data.PaginateQuery;
  total.value = data.total;
});

// handling the search form
const handlingSearch = () => {
  getPaginate(1, props.getter, search.value).then((data) => {
    result.value = data.PaginateQuery;
    total.value = data.total;
  });
};
const pagination = (e, page) => {
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
  <TableHeader :titre="titre" :addDestination="addName">{{
    total
  }}</TableHeader>
  <div
    class="bg-white relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full"
    style="max-height: 75vh"
  >
    <form @submit.prevent="handlingSearch">
      <div class="relative border-2 border-gray-100 m-4 rounded-lg">
        <div class="absolute top-4 left-3">
          <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
        </div>
        <input
          v-model="search"
          @keyup="handlingSearch"
          type="text"
          name="search"
          class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
          placeholder="Search ..."
        />
        <div class="absolute top-2 right-2">
          <button
            type="submit"
            class="h-10 w-20 text-white rounded-lg bg-red-600 hover:bg-red-800 duration-100"
          >
            Search
          </button>
        </div>
      </div>
    </form>
    <div class="tableauContainer" v-if="result.data && result.data.length > 0">
      <table class="w-full text-sm text-center text-gray-500">
        <!-- Search -->
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
          <tr>
            <!-- columns = [{name: ,key: },{}] -->
            <th
              scope="col"
              class="px-6 py-3"
              v-for="column in columns"
              :key="column.key"
            >
              {{ column.name }}
            </th>
            <th scope="col" class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            class="bg-white border-b"
            v-for="row in result.data"
            :key="row.id"
          >
            <td
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
              v-for="column in columns"
              :key="column.key"
            >
              <router-link
                v-if="column.isLink"
                :to="{ name: column.toName, params: { id: row[column.toID] } }"
                :class="{ uppercase: column.capitalize }"
                >{{ row[column.key] ?? "N/A" }}</router-link
              >
              <p v-else :class="{ uppercase: column.capitalize }">
                {{ row[column.key] ?? "N/A" }}
              </p>
            </td>
            <!-- actions = [{label: , redirectToAction:  ,addClass:"" },{},{},...] -->
            <td class="flex px-6 py-4 space-x-4 justify-center">
              <div v-for="action in actions" :key="action.label">
                <router-link
                  v-if="action.label !== 'Supprimer'"
                  :to="{
                    name: action.redirectToAction,
                    params: { id: row[action.toID] },
                  }"
                  class="font-medium text-black hover:underline"
                  :class="action.addClass"
                  >{{ action.label }}</router-link
                >
                <form
                  v-else
                  method="post"
                  @submit.prevent="DeleteHandler(row.id)"
                  class="inline-block font-medium text-red-600"
                >
                  <button type="submit" class="hover:underline">
                    Supprimer
                  </button>
                </form>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <nav aria-label="Page navigation" class="m-5 text-center">
        <ul class="inline-flex -space-x-px text-sm">
          <li v-for="page in result.links">
            <button
              @click.self="pagination($event, page.url)"
              :disabled="page.url === null"
              :class="
                page.active
                  ? '!text-blue-600  !border-blue-300 !bg-blue-50 hover:!bg-blue-100 hover:!text-blue-700'
                  : ''
              "
              class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 hover:bg-gray-100 hover:text-gray-700 disabled:opacity-70 disabled:cursor-not-allowed"
              v-html="page.label"
            ></button>
          </li>
        </ul>
      </nav>
    </div>
    <div
      class="bg-white relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full p-12 flex justify-center items-center"
      style="max-height: 75vh"
      v-else
    >
      <p class="font-serif text-3xl">Aucune information a afficher</p>
    </div>
  </div>
</template>
