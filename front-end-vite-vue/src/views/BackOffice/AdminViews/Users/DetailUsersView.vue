<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="UserFetched != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        L'utilisateur: {{ UserFetched.nom }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        ci-dessous les details de l'utilisateur {{ UserFetched.id }}
      </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5">
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">ID</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ UserFetched.id }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Nom Complet
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ UserFetched.nom + " - " + UserFetched.prenom }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Email
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ UserFetched.email }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            N* Telephone
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ UserFetched.telephone }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">Role</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max uppercase">
            {{ UserFetched.role }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Status
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max uppercase">
            {{ UserFetched.status }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Last Seen
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{
              new Date(UserFetched.last_activity).getFullYear() == 1970
                ? "Never"
                : new Date(UserFetched.last_activity)
            }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-6">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Date de creation
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ new Date(UserFetched.created_at).toISOString().slice(0, 10) }}
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
const UserFetched = ref(null);
const router = useRouter();
const store = useStore();

// loading the user
getById(Endpoints.user__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    UserFetched.value = data;
    console.log(UserFetched.value);
  } else {
    store.commit("setError", "Utilisateur introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "usersView",
    });
  }
});
</script>
