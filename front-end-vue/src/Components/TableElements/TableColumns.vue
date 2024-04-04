<template>
    <!-- columns = [{name: ,key: },{}] -->
    <th scope="col" class="px-6 py-3 " :class="{ 'cursor-pointer': column.sortable }" v-for="column in     columns    "
        :key="column.key" data-sort="none" @click.self=" sortingHandle($event, column)">
        {{ column.name }}
    </th>
    <th scope="col" class="px-6 py-3">Actions</th>
</template>
<script setup>
const props = defineProps(["columns"]);
const emit = defineEmits(['sort']);
const sortingHandle = (e, column) => {
    if (column.sortable) {
        if (e.target.dataset.sort == "none") {
            e.target.dataset.sort = "asc";
        } else if (e.target.dataset.sort == "asc") {
            e.target.dataset.sort = "desc";
        } else if (e.target.dataset.sort == "desc") {
            e.target.dataset.sort = "none";
        }
        emit('sort', column.key, e.target.dataset.sort)
    }
}
</script>
