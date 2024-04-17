<template>
  <nav aria-label="Page navigation" class="m-5 text-center" :class="addClass">
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
</template>
<script setup>
import getPaginate from "@/Composables/Getters/getPaginate";

const props = defineProps(["result", "addClass", "requestParams", "getter"]);
const emits = defineEmits(["updateResult"]);

// pagination
const pagination = (e, page) => {
  const button = e.target;
  button.classList.add("!cursor-progress");
  if (page !== null) {
    const number = page.split("page=")[1];
    getPaginate(
      number,
      props.getter,
      props.requestParams.sort,
      props.requestParams.sortColumn,
      props.requestParams.search,
      props.requestParams.searchColumn,
      "id"
    ).then((data) => {
      if (data) {
        emits("updateResult", data.PaginateQuery);
        button.classList.remove("!cursor-progress");
      }
    });
  }
};
</script>
