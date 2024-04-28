<template>
  <td
    scope="row"
    class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap"
    v-for="column in columns"
    :key="column.key"
    v-show="!column.isHidden"
  >
    <div
      class="content flex justify-center items-center"
      v-if="column.name != 'actions'"
    >
      <router-link
        v-if="column.isLink && row[column.toID] && column.toName"
        :to="{ name: column.toName, params: { id: row[column.toID] } }"
        :class="{ uppercase: column.capitalize }"
        >{{ row[column.key] ?? "N/A" }}</router-link
      >
      <div class="w-11 h-11" v-else-if="column.isImage && row[column.key]">
        <img
          :src="Endpoints.getStoragePath + row[column.key]"
          class="w-full h-full object-cover"
        />
      </div>
      <div
        class="w-20 h-max py-1 px-3 rounded-lg"
        :class="{
          'bg-red-500': row[column.key] == 'onhold',
          'bg-green-500': row[column.key] == 'approved',
          'bg-gray-500': row[column.key] == 'disabled',
        }"
        @click="emitChangeStatus(row, column.key)"
        v-else-if="column.isStatus"
      >
        <p
          :class="{ uppercase: column.capitalize }"
          class="text-white rounded-lg flex justify-center items-center"
        >
          {{ row[column.key] ?? " N/A" }}
        </p>
      </div>
      <p v-else :class="{ uppercase: column.capitalize }">
        {{ row[column.key] ?? "N/A" }}
      </p>
    </div>
    <div class="actions" v-else>
      <ActionsTable :actions="actions" :row="row" @delete="emitDelete(row.id)">
      </ActionsTable>
    </div>
  </td>
</template>
<script setup>
import ActionsTable from "@/Components/TableElements/ActionsTable.vue";
import Endpoints from "@/assets/JS/Endpoints";

const props = defineProps(["columns", "row", "actions"]);
const emits = defineEmits(["delete", "ChangeStatus"]);

const emitDelete = (id) => {
  emits("delete", id);
};
const emitChangeStatus = (row, column) => {
  emits("ChangeStatus", row, column);
};
</script>
