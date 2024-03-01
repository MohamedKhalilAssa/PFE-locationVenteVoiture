<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <form
      method="POST"
      @submit.prevent="RegisterHandling"
      class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-lg"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Creer une annonce</h2>
      </header>

      <div class="mb-6">
        <label for="nom" class="inline-block text-lg mb-2 required">Nom</label>
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
      <div class="mb-6">
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
          name="Telephone"
          placeholder="Exemple: 06 XX XX XX XX"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.telephone">
            {{ errors.telephone[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
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
      <div class="mb-6">
        <button
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          S'inscrire
        </button>
      </div>

      <div class="mt-8">
        <p>
          Vous avez deja un compte?
          <router-link
            to="/login"
            class="text-blue-500 hover:scale-105 duration-300 inline-block"
            >Se connecter</router-link
          >
        </p>
      </div>
    </form>
    <div
      class="errors max-w-lg text-center mx-auto mb-10 mt-10"
      v-if="serverError"
    >
      <p class="text-red-600">{{ serverError }}</p>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import getMarques from "@/Composables/getMarques";

const form = ref({
  titre: null,
  description: null,
  ville: null,
  type_annonce: null,
  statut_annonce: null,
  etat: null,
  carburant: null,
  kilometrage: null,
  couleur: null,
  annee_fabrication: null,
  options: [],
  prix_vente: 0,
  prix_location: 0,
  disponibilite_vente: false,
  disponibilite_location: false,
  images: [],
});

getMarques();
</script>

<style scoped>
main {
  min-height: 100vh;
}
</style>
