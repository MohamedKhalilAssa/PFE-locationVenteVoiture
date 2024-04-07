<template>
  <div
    class="relative m-2 rounded-lg flex flex-col-reverse justify-between gap-4 sm:flex-row"
    :class="addClass"
  >
    <label class="relative h-10 sm:max-w-64 lg:max-w-96 rounded-sm">
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
        class="w-full rounded-sm z-0 focus:shadow focus:outline-none"
        placeholder="Search ..."
      />
      <i
        class="absolute top-1/3 right-2 fa-solid fa-magnifying-glass"
        v-if="!searching"
      ></i>
      <i
        class="absolute right-2 text-2xl fa-solid fa-xmark cursor-pointer"
        style="top: 0.35rem"
        @click.self="clearSearch(columns)"
        v-else
      ></i>
    </label>
    <select
      class="h-10 rounded-sm z-0"
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
        v-show="!column.isHidden"
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
  emits("search", search.value, searchColumn.value || columns[1].key, columns[0].key);
};
</script>
