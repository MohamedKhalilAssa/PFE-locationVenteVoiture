<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <div
      method="POST"
      class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-2xl w-full"
    >
      <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">Modifier mon profil</h2>
        <p class="mb-4">Modifier vos informations publiques ou mot de passe</p>
      </header>
      <div class="donnees mt-8 mb-8">
        <h3
          class="relative text-xl sm:text-3xl leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:-bottom-1 after:w-10 pb-1"
        >
          Données Personnel
        </h3>
        <div class="mb-6 mt-4">
          <label for="nom" class="inline-block text-lg mb-2 required"
            >Nom</label
          >
          <input
            v-model="form.nom"
            id="nom"
            type="text"
            class="border border-gray-600 rounded p-2 w-full"
            name="nom"
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
            name="prenom"
            placeholder="Exemple: John"
          />
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.prenom">
              {{ errors.prenom[0] }}
            </p>
          </div>
        </div>
      </div>
      <div class="contact mb-8">
        <h3
          class="relative text-3xl leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:-bottom-1 after:w-10 pb-1"
        >
          Contact
        </h3>
        <div class="mb-6 mt-4">
          <label for="email" class="inline-block text-lg mb-2 required"
            >Email</label
          >
          <input
            v-model="form.email"
            id="email"
            type="email"
            class="border border-gray-600 rounded p-2 w-full"
            name="email"
            placeholder="Exemple: exemple@exemple.com"
          />
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.email">
              {{ errors.email[0] }}
            </p>
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
            name="Telephone"
            placeholder="Exemple: 06 XX XX XX XX"
          />
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.telephone">
              {{ errors.telephone[0] }}
            </p>
          </div>
        </div>
      </div>
      <div class="mb-6 flex justify-center items-center">
        <button
          type="submit"
          ref="buttonData"
          @click="editProfileHandling"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier les données
        </button>
      </div>
      <div class="password mb-4">
        <h3
          class="relative text-3xl leading-6 font-medium text-gray-900 block after:border-b-2 after:border-red-500 after:absolute after:left-0 after:-bottom-1 after:w-10 pb-1"
        >
          Mot de Passe
        </h3>
        <div class="mb-6 mt-4">
          <label for="password" class="inline-block text-lg mb-2 required"
            >Mot de Passe</label
          >
          <input
            v-model="form.password"
            id="password"
            type="password"
            class="border border-gray-600 rounded p-2 w-full"
            name="password"
          />
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.password">
              {{ errors.password[0] }}
            </p>
          </div>
        </div>
        <div class="mb-6">
          <label for="password2" class="inline-block text-lg mb-2 required"
            >Confirmation du Mot de Passe</label
          >
          <input
            v-model="form.password_confirmation"
            id="password2"
            type="password"
            class="border border-gray-600 rounded p-2 w-full"
            name="password_confirmation"
          />
        </div>
      </div>
      <div class="mb-6 flex justify-center items-center">
        <button
          type="submit"
          ref="buttonPassword"
          @click="editPassword"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Modifier mon mot de passe
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import EditToDB from "@/Composables/CRUDRequests/EditToDB";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import Endpoints from "@/assets/JS/Endpoints";
import { onMounted, ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import getAuthenticatedUser from "@/Composables/Getters/getAuthenticatedUser";

const errors = ref(null);
const buttonData = ref(null);
const buttonPassword = ref(null);
const router = useRouter();
const store = useStore();

const form = ref({
  id: null,
  nom: null,
  prenom: null,
  email: null,
  telephone: null,
  password: null,
  password_confirmation: null,
});
const setForm = (user) => {
  form.value = {
    id: user.id,
    nom: user.nom,
    prenom: user.prenom,
    email: user.email,
    telephone: user.telephone,
    password: null,
    password_confirmation: null,
  };
};
const fetching = () => {
  getAuthenticatedUser().then((data) => {
    if (data) {
      setForm(data);
    } else {
      store.commit("setError", "Utilisateur introuvable");
      store.commit("setErrorCode", "404");
    }
  });
};
fetching();
const editProfileHandling = async () => {
  // editing profile data
  const formData = new FormData();
  formData.append("nom", form.value.nom);
  formData.append("prenom", form.value.prenom);
  formData.append("email", form.value.email);
  formData.append("telephone", form.value.telephone);

  EditToDB(
    buttonData.value,
    Endpoints.user__get_or_update_or_delete,
    form.value.id,
    formData,
    "",
    errors
  ).then((response) => {
    console.log(response);
    buttonData.value.disabled = false;
    if (response) fetching();
  });
};

const editPassword = async () => {
  // editing password
  const passData = new FormData();
  passData.append("password", form.value.password);
  passData.append("password_confirmation", form.value.password_confirmation);
  AddToDB(
    buttonPassword.value,
    Endpoints.user__change_password,
    passData,
    "",
    errors
  ).then(() => {
    form.value.password = null;
    form.value.password_confirmation = null;
    buttonPassword.value.disabled = false;
  });
};
</script>
