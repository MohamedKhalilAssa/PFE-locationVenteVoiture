<template>
  <td class="flex px-6 py-4 space-x-4 justify-center">
    <!-- actions = [{label: , redirectToAction:  ,addClass:"",isCustom },{},{},...] -->
    <div v-for="action in actions" :key="action.label">
      <form
        v-if="action.label == 'Supprimer'"
        method="post"
        @submit.prevent="$emit('delete')"
        class="inline-block font-medium text-red-600"
      >
        <button type="submit" class="hover:underline">Supprimer</button>
      </form>
      <router-link
        v-else
        :to="{
          name: action.redirectToAction,
          params: { id: row[action.toID] },
        }"
        class="font-medium text-black hover:underline"
        :class="action.addClass"
        >{{ action.label }}</router-link
      >
    </div>
  </td>
</template>
<script setup>
const props = defineProps(["actions", "row"]);
</script>
