<template>
  <td
    scope="row"
    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
    v-for="column in columns"
    :key="column.key"
    v-show="!column.isHidden"
  >
    <router-link
      v-if="column.isLink && column.toID"
      :to="{ name: column.toName, params: { id: row[column.toID] } }"
      :class="{ uppercase: column.capitalize }"
      >{{ row[column.key] ?? "N/A" }}</router-link
    >
    <router-link
      v-else-if="column.isLink"
      :to="{ name: column.toName }"
      :class="{ uppercase: column.capitalize }"
    >
      {{ row[column.key] ?? "N/A" }}</router-link
    >
    <p v-else :class="{ uppercase: column.capitalize }">
      {{ row[column.key] ?? "N/A" }}
    </p>
  </td>
</template>
<script setup>
const props = defineProps(["columns", "row"]);
</script>
