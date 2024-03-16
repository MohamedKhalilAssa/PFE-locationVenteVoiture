<template>
  <div
    class="relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full"
    style="max-height: 75vh"
  >
    <table class="w-full text-sm text-center text-gray-500">
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
        <tr class="bg-white border-b" v-for="row in result.data" :key="row.id">
          <td
            scope="row"
            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
            v-for="column in columns"
            :key="column.key"
          >
            <router-link
              v-if="column.isLink"
              :to="{ name: column.toName, params: { id: row[column.toID] } }"
              >{{ row[column.key] }}</router-link
            >
            <p v-else>{{ row[column.key] }}</p>
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
                @submit.prevent="DeleteFromDB(deleteFrom, row.id, loader)"
                class="inline-block font-medium text-red-600"
              >
                <button type="submit" class="hover:underline">Supprimer</button>
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
</template>
<script setup>
import DeleteFromDB from "@/Composables/CRUDRequests/DeleteFromDB";

const props = defineProps(["columns", "actions", "getter", "deleteFrom"]);
// handling GetterFunction
const { ...getterElements } = props.getter();
// extracting loader
const loaderFromGetter = Object.entries(getterElements).filter(([key, value]) =>
  key.includes("load")
);
let loader = loaderFromGetter[0][1];
// extracting result
const resultFromGetter = Object.entries(getterElements).filter(([key, value]) =>
  key.includes("esult")
);
let result = resultFromGetter[0][1];
// calling the loader
loader();

const pagination = (e, page) => {
  const button = e.target;
  button.classList.add("!cursor-progress");
  if (page !== null) {
    button.classList.add = "!cursor-progress";
    const number = page.split("page=")[1];
    loader(number).then(() => {
      button.classList.remove("!cursor-progress");
    });
  }
};
</script>
