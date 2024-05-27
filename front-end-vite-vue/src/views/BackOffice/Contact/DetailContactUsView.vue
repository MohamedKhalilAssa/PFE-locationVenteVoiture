<template>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto"
    v-if="ContactFetched != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        La demande de {{ ContactFetched.full_name }}
      </h3>
    </div>
    <div class="border-t border-gray-200 px-4 py-5">
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">ID</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ ContactFetched.id }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Nom Complet
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            <router-link
              :to="{ name: 'detailsUser', params: { id: ContactFetched.id } }"
              >{{ ContactFetched.full_name }}</router-link
            >
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Email
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ ContactFetched.email }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Objet
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ ContactFetched.object }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            La demande
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max uppercase">
            {{ ContactFetched.message }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-8">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            La Reponse
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max uppercase">
            {{ ContactFetched.is_answered ? "Repondu" : "Non repondu" }}
          </dd>
        </div>
        <div class="py-3 sm:py-5 flex items-end gap-6">
          <dt class="text-sm font-medium text-gray-500 min-w-max w-24">
            Date de creation
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
            {{ new Date(ContactFetched.created_at).toISOString().slice(0, 10) }}
          </dd>
        </div>
      </dl>
    </div>
  </div>
  <div
    class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto p-4 mt-6"
    v-if="ContactFetched != null"
  >
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Envoyer une reponse
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        si vous repondez plusieurs fois seul la derniere sera prise en compte
      </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5">
      <form @submit.prevent="submit" class="flex flex-col gap-4 items-end">
        <textarea
          rows="4"
          class="block p-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500"
          placeholder="Message..."
          v-model="form.answer"
        ></textarea>
        <button
          type="submit"
          ref="button"
          class="text-white mt-4 max-w-32 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
        >
          Envoyer
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import getById from "@/Composables/Getters/getById";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import { setFormData } from "@/Composables/Helpers/globalFunctions";

const props = defineProps(["id"]);
const ContactFetched = ref(null);
const router = useRouter();
const store = useStore();
const button = ref(null);
const errors = ref(null);
const form = ref({
  answer: null,
});

// loading the user
getById(Endpoints.contact__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    ContactFetched.value = data;
  } else {
    store.commit("setError", "Contact introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "ContactUsBackView",
    });
  }
});
const submit = () => {
  const formData = setFormData(form);
  EditToDB(
    button.value,
    Endpoints.contact__answer,
    props.id,
    formData,
    "ContactUsBackView",
    errors
  );
};
</script>
