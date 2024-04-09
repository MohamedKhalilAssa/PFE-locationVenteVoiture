<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="LogFetched != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">LOG DETAILS</h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous les details du log {{ LogFetched.id }}
      </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5">
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">ID</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ LogFetched.id }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Utilisateur
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            <router-link
              v-if="LogFetched.user_id"
              :to="{ name: 'detailsUser', params: { id: LogFetched.user_id } }"
            >
              {{ LogFetched.user_id }}
            </router-link>
            <p v-else>N/A</p>
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Ip Address
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ LogFetched.ip_address }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            User Agent
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ LogFetched.user_agent }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Action
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max uppercase">
            {{ LogFetched.action }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Referrer
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ LogFetched.referrer }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">Url</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ LogFetched.url }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-6">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Date de creation
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ new Date(LogFetched.created_at).toISOString().slice(0, 10) }}
          </dd>
        </div>
      </dl>
    </div>
  </div>
</template>

<script setup>
import getById from "@/Composables/Getters/getById";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const LogFetched = ref(null);
const router = useRouter();
const store = useStore();

// loading the brand
getById(Endpoints.analytics__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    LogFetched.value = data;
  } else {
    store.commit("setError", "Log introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "logsView",
    });
  }
});
// loading the modeles associated with it
</script>
