<template>
  <PartialSection :title="title"></PartialSection>
  <main class="py-10 px-12 flex flex-col justify-between items-center">
    <div class="content flex flex-wrap justify-center gap-7">
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

const props = defineProps(["getter", "title"]);

const result = ref([]);

const requestParams = ref({
  sort: "none",
  sortColumn: "id",
  search: "",
  searchColumn: "nom",
});

getPaginate(
  1,
  props.getter,
  requestParams.value.sort,
  requestParams.value.sortColumn,
  requestParams.value.search,
  requestParams.value.searchColumn,
  "id"
).then((data) => {
  if (data) {
    result.value = data.PaginateQuery;
  }
});

// for pagination
const updateResult = (data) => {
  result.value = data;
};
</script>
<style></style>
