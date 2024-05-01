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
        <button v-if="!action.hasIcon" type="submit" class="hover:underline">
          Supprimer
        </button>
        <button v-else type="submit" class="hover:underline">
          <i class="text-xl fa fa-trash" aria-hidden="true"></i>
        </button>
      </form>
      <router-link
        v-else
        :to="{
          name: action.redirectToAction,
          params: { id: row[action.toID] },
        }"
        class="font-medium text-black hover:underline"
        :class="action.addClass"
      >
        <span v-if="!action.hasIcon">{{ action.label }}</span>
        <i v-else class="text-xl" :class="action.hasIcon"></i>
      </router-link>
    </div>
  </td>
</template>
<script setup>
const props = defineProps(["actions", "row"]);
</script>
