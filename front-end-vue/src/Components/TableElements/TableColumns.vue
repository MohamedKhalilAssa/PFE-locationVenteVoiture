<template>
  <!-- const column = [ {name: ... , key: ... , sortable: ..., isHidden: ... , capitalize: ... , isLink: ... , toName: ... ,
     toID: ...}]  -->
  <th
    scope="col"
    class="px-3 py-3 space-x-2"
    :class="{ 'cursor-pointer': column.sortable }"
    v-for="column in columns"
    :key="column.key"
    data-sort="none"
    @click.self="sortingHandle($event, column)"
    v-show="!column.isHidden"
  >
    <span @click.self="clickOnName($event)">{{ column.name }}</span>
  </th>
  <th scope="col" class="px-6 py-3">Actions</th>
</template>
<script setup>
import { ref } from "vue";

const props = defineProps(["columns"]);
const emit = defineEmits(["sort"]);

const sortingHandle = (e, column) => {
  if (column.sortable) {
    if (e.target.dataset.sort == "none") {
      e.target.dataset.sort = "asc";
    } else if (e.target.dataset.sort == "asc") {
      e.target.dataset.sort = "desc";
    } else if (e.target.dataset.sort == "desc") {
      e.target.dataset.sort = "none";
    }
    const th = document.querySelectorAll("th");
    th.forEach((thE) => {
      thE.classList.remove("headerSortDown");
      thE.classList.remove("headerSortUp");
    });
    if (e.target.dataset.sort == "asc") {
      e.target.classList.add("headerSortUp");
    } else if (e.target.dataset.sort == "desc") {
      e.target.classList.add("headerSortDown");
    }
    emit("sort", column.key, e.target.dataset.sort);
  }
};

const clickOnName = (e) => {
  e.target.parentElement.click();
};
</script>
<style>
.headerSortDown:after,
.headerSortUp:after {
  content: " ";
  position: relative;
  left: 6px;
  border: 6px solid transparent;
}

.headerSortDown:after {
  top: 10px;
  border-top-color: silver;
}

.headerSortUp:after {
  bottom: 15px;
  border-bottom-color: silver;
}

.headerSortDown,
.headerSortUp {
  padding-right: 4px;
}
</style>
