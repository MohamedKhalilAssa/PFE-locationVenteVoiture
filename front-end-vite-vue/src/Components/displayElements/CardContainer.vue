<template>
  <PartialSection
    @updatePage="updatePage"
    :title="title"
    :type="type"
    :getter="getter"
    :filters="filters"
  ></PartialSection>
  <main
    ref="contentDiv"
    class="py-10 pt-28 px-12 flex flex-col justify-between items-center lg:pt-0"
  >
    <div class="content flex flex-wrap justify-center gap-7">
      <div
        class="relative sm:pr-24 m-2 w-full rounded-lg flex flex-col-reverse justify-end gap-4 sm:flex-row"
      >
        <select
          class="h-10 rounded-sm p-2 z-0 border border-black w-full sm:max-w-max"
          @change="sort"
        >
          <option selected value="none">Sort By</option>
          <option
            scope="row"
            v-for="state in [
              { key: 'asc-' + price, name: 'Par prix croissant' },
              { key: 'desc-' + price, name: 'Par prix décroissant' },
              {
                key: 'asc-annee_fabrication',
                name: 'Par annee de fabrication croissante',
              },
              {
                key: 'desc-annee_fabrication',
                name: 'Par annee de fabrication décroissante',
              },
              {
                key: 'desc-created_at',
                name: 'Du plus recent',
              },
              {
                key: 'asc-created_at',
                name: 'Du plus ancien',
              },
            ]"
            :key="state.key"
            :value="state.key"
          >
            {{ state.name }}
          </option>
        </select>
      </div>
      <DisplayCard
        v-for="card in result.data"
        :key="card.id"
        :data="card"
      ></DisplayCard>
    </div>
    <div class="navigation">
      <Pagination
        :result="result"
        :requestParams="requestParams"
        :getter="getter"
        :currentFilters="currentFilters"
        @updateResult="updateResult"
        v-if="result.data && result.last_page > 1"
      ></Pagination>
    </div>
  </main>
</template>
<script setup>
import DisplayCard from "@/Components/displayElements/DisplayCard.vue";
import Pagination from "@/Components/Pagination.vue";
import getPaginate from "@/Composables/Getters/getPaginate";
import PartialSection from "@/views/Partials/PartialSection.vue";
import { computed, ref } from "vue";

const props = defineProps(["filters", "getter", "title", "type"]);
const contentDiv = ref(null);
const result = ref([]);
const currentFilters = ref({});
const price = computed(() => {
  return props.type == "location" ? "prix_location" : "prix_vente";
});
const requestParams = ref({
  sort: "none",
  sortColumn: "",
  search: "",
  searchColumn: "",
});

getPaginate(1, props.getter, requestParams.value, props.filters).then(
  (data) => {
    if (data) {
      result.value = data.PaginateQuery;
    }
  }
);
// sorting
const sort = (e) => {
  [requestParams.value.sort, requestParams.value.sortColumn] =
    e.target.value.split("-");
  getPaginate(1, props.getter, requestParams.value).then((data) => {
    if (data) {
      result.value = data.PaginateQuery;
    }
  });
};
// for pagination
const updateResult = (data) => {
  result.value = data;
  contentDiv.value.scrollIntoView({
    behavior: "smooth",
    block: "start",
    inline: "nearest",
  });
};
const updatePage = (data, filter) => {
  result.value = data;
  currentFilters.value = filter;
};
</script>
<style></style>
