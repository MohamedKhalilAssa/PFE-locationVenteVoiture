<template>
  <td class="flex px-6 py-4 space-x-4 justify-center">
    <!-- actions = [{label: , redirectToAction:  ,addClass:"" },{},{},...] -->
    <div v-for="action in actions" :key="action.label">
      <router-link
        v-if="action.label !== 'Supprimer'"
        :to="{
          name: action.redirectToAction,
          params: { id: row[action.toID] },
        }"
        class="font-medium text-black hover:underline"
        :class="action.addClass"
        >{{ action.label }}</router-link
      >
      <form
        v-else
        method="post"
        @submit.prevent="$emit('delete')"
        class="inline-block font-medium text-red-600"
      >
        <button type="submit" class="hover:underline">Supprimer</button>
      </form>
    </div>
  </td>
</template>
<script setup>
const props = defineProps(["actions", "row"]);
</script>
