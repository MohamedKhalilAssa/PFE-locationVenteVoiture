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
        <label for="nom" class="inline-block text-lg mb-2 required"
          >Titre</label
        >
        <input
          v-model="form.titre"
          id="titre"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          name="titre"
          placeholder="Exemple: Toyota Corolla Modele 2022 ..."
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.titre">{{ errors.titre[0] }}</p>
        </div>
      </div>
      <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2 required"
          >Description</label
        >
        <textarea
          v-model="form.description"
          id="description"
          type="text"
          class="border border-gray-600 rounded p-2 w-full min-h-20"
          name="description"
          placeholder="Exemple: Une voiture sportive, élégante et efficiente, offrant un équilibre parfait entre performances et confort"
        ></textarea>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.description">
            {{ errors.description[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="ville" class="inline-block text-lg mb-2 required"
          >Ville</label
        >
        <input
          v-model="form.ville"
          id="ville"
          type="text"
          class="border border-gray-600 rounded p-2 w-full"
          name="ville"
          placeholder="Exemple: Casablanca"
        />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.ville">{{ errors.ville[0] }}</p>
        </div>
      </div>

      <div class="mb-6">
        <label for="type_annonce" class="inline-block text-lg mb-2 required"
          >Type d'annonce
        </label>
        <select
          v-model="form.type_annonce"
          id="type_annonce"
          class="border border-gray-600 rounded p-2 w-full"
          name="type_annonce"
        >
          <option selected :value="null">Choisir un type d'annonce</option>
          <option value="vente">Vente</option>
          <option value="location">Location</option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.type_annonce">
            {{ errors.type_annonce[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="etat" class="inline-block text-lg mb-2 required"
          >L'etat de la Voiture
        </label>
        <select
          v-model="form.etat"
          id="etat"
          class="border border-gray-600 rounded p-2 w-full"
          name="etat"
        >
          <option selected :value="null">Choisir l'etat de la Voiture</option>
          <option value="neuf">Neuf</option>
          <option value="occasion">Occasion</option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.etat">
            {{ errors.etat[0] }}
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

const errors = ref(null);

getMarques();
</script>

<style scoped>
main {
  min-height: 100vh;
}
.required:after {
  content: " *";
  color: red;
}
</style>
