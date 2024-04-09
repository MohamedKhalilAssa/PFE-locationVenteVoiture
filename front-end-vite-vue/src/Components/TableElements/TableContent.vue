<template>
  <td
    scope="row"
    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
    v-for="column in columns"
    :key="column.key"
    v-show="!column.isHidden"
  >
    <div class="content" v-if="column.name != 'actions'">
      <router-link
        v-if="column.isLink && row[column.toID] && column.toName"
        :to="{ name: column.toName, params: { id: row[column.toID] } }"
        :class="{ uppercase: column.capitalize }"
        >{{ row[column.key] ?? "N/A" }}</router-link
      >
      <p v-else :class="{ uppercase: column.capitalize }">
        {{ row[column.key] ?? "N/A" }}
      </p>
    </div>
    <div class="actions" v-else>
      <ActionsTable
        :actions="actions"
        :row="row"
        @delete="emitDelete(row.id)"
      ></ActionsTable>
    </div>
  </td>
</template>
<script setup>
import ActionsTable from "@/Components/TableElements/ActionsTable.vue";

const props = defineProps(["columns", "row", "actions"]);
const emits = defineEmits(["delete"]);

const emitDelete = (id) => {
  emits("delete", id);
};
</script>
