<template>
  <PartialSection
    @updatePage="updatePage"
    :title="title"
    :type="type"
    :getter="getter"
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
          v-model="requestParams.sort"
          @change="sort"
        >
          <option selected value="none">Sort By</option>
          <option
            scope="row"
            v-for="state in [
              { key: 'asc', name: 'Par prix croissant' },
              { key: 'desc', name: 'Par prix décroissant' },
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
import { ref } from "vue";

const props = defineProps(["getter", "title", "type"]);
const contentDiv = ref(null);
const result = ref([]);

const requestParams = ref({
  sort: "none",
  sortColumn: props.type == "location" ? "prix_location" : "prix_vente",
  search: "",
  searchColumn: "",
});
const currentFilters = ref({});

getPaginate(1, props.getter, requestParams.value, "").then((data) => {
  if (data) {
    result.value = data.PaginateQuery;
  }
});

const sort = () => {
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
