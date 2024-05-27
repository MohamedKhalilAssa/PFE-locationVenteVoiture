<template>
  <div
    class="relative m-2 rounded-lg flex flex-col-reverse justify-between gap-4 sm:flex-row"
    :class="addClass"
  >
    <label
      class="relative h-10 w-full sm:max-w-72 lg:max-w-96 rounded-sm border border-black"
    >
      <input
        v-model="search"
        @keyup="
          $emit(
            'search',
            search,
            searchColumn || columns[1].key,
            columns[0].key
          )
        "
        type="text"
        name="search"
        class="w-full h-full rounded-sm focus:shadow focus:outline-none p-2"
        placeholder="Search ..."
      />
      <i
        class="absolute top-3 right-2 fa-solid fa-magnifying-glass"
        v-if="!searching"
      ></i>
      <i
        class="absolute top-1 right-2 text-2xl fa-solid fa-xmark cursor-pointer"
        @click.self="clearSearch(columns)"
        v-else
      ></i>
    </label>
    <select
      class="h-10 rounded-sm p-2 z-0 border border-black w-full sm:max-w-max"
      v-model="searchColumn"
      @change="
        $emit('search', search, searchColumn || columns[1].key, columns[0].key)
      "
    >
      <option selected value="">Filter By</option>
      <option
        scope="row"
        v-for="column in columns"
        :key="column.key"
        :value="column.key"
        v-show="
          !column.isHidden && column.name != 'actions' && !column.unsearchable
        "
      >
        {{ column.name }}
      </option>
    </select>
  </div>
</template>
<script setup>
import { computed, ref } from "vue";
const props = defineProps(["addClass", "columns"]);
const search = ref("");
const searchColumn = ref("");
const emits = defineEmits(["search"]);

const searching = computed(() => {
  let regex = /\S/g;
  let str = search.value;
  if (str == "" || !regex.test(str)) {
    return false;
  } else return true;
});
const clearSearch = (columns) => {
  search.value = "";
  emits(
    "search",
    search.value,
    searchColumn.value || columns[1].key,
    columns[0].key
  );
};
</script>
