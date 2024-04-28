<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <form
      method="POST"
      @submit.prevent="editUserHandling"
      class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-lg"
    >
      <header class="text-center mb-8">
        <h2 class="text-2xl font-bold uppercase">Modifier un utilisateur</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required">Nom</label>
        <input
          v-model="form.nom"
          id="nom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: Doe"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.nom">{{ errors.nom[0] }}</p>
        </div>
      </div>
      <div class="mb-6">
        <label for="prenom" class="inline-block text-lg mb-2 required"
          >Prenom</label
        >
        <input
          v-model="form.prenom"
          id="prenom"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: John"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.prenom">
            {{ errors.prenom[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2 required"
          >Email</label
        >
        <input
          v-model="form.email"
          id="email"
          type="email"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: exemple@exemple.com"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
      </div>

      <div class="mb-6">
        <label for="Telephone" class="inline-block text-lg mb-2 required"
          >Telephone
        </label>
        <input
          v-model="form.telephone"
          id="Telephone"
          type="test"
          class="border border-gray-600 rounded p-2 w-full"
          placeholder="Exemple: 06 XX XX XX XX"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.telephone">
            {{ errors.telephone[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6" v-if="$store.getters.getUser.role === 'root'">
        <label for="role" class="inline-block text-lg mb-2 required"
          >Le Role
        </label>
        <select
          v-model="form.role"
          id="role"
          class="border border-gray-600 rounded p-2 w-full"
        >
          <option
            v-for="role in ['Admin', 'Client']"
            :key="role"
            :value="role.toLowerCase()"
          >
            {{ role }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.role">
            {{ errors.role[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6 flex justify-center items-center">
        <button
          type="submit"
          ref="button"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier l'utilisateur
        </button>
      </div>
    </form>
  </section>
</template>

<script setup>
import { ref, watchEffect } from "vue";
import { useRouter } from "vue-router";
import getById from "@/Composables/Getters/getById";
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";
import { setForm, setFormData } from "@/Composables/Helpers/globalFunctions";

// fetching existing modele
const props = defineProps(["id"]);

const form = ref({
  nom: null,
  prenom: null,
  email: null,
  telephone: null,
  role: null,
});

const errors = ref(null);
const router = useRouter();
const store = useStore();
const button = ref(null);

getById(Endpoints.user__get_or_update_or_delete, props.id).then((data) => {
  if (data) {
    setForm(form, data);
  } else {
    store.commit("setError", "Utilisateur introuvable");
    store.commit("setErrorCode", "404");
    router.push({
      name: "usersView",
    });
  }
});
const editUserHandling = async () => {
  const formData = setFormData(form);
  EditToDB(
    button.value,
    Endpoints.user__get_or_update_or_delete,
    props.id,
    formData,
    "usersView",
    errors
  );
};
</script>

<style>
.required:after {
  content: " *";
  color: red;
}
</style>
