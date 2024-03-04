<template>
  <section class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16">
    <form method="POST" @submit.prevent="RegisterHandling"
      class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-lg">
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Creer une annonce</h2>
      </header>

      <div class="mb-6">
        <label for="titre" class="inline-block text-lg mb-2 required">Titre</label>
        <input v-model="form.titre" id="titre" type="text" class="border border-gray-600 rounded p-2 w-full" name="titre"
          placeholder="Exemple: Toyota Corolla Modele 2022 ..." />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.titre">{{ errors.titre[0] }}</p>
        </div>
      </div>
      <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2 required">Description</label>
        <textarea v-model="form.description" id="description" type="text"
          class="border border-gray-600 rounded p-2 w-full min-h-24" name="description"
          placeholder="Exemple: Une voiture sportive, élégante et efficiente, offrant un équilibre parfait entre performances et confort"></textarea>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.description">
            {{ errors.description[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="ville" class="inline-block text-lg mb-2 required">Ville</label>
        <input v-model="form.ville" id="ville" type="text" class="border border-gray-600 rounded p-2 w-full" name="ville"
          placeholder="Exemple: Casablanca" />
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.ville">{{ errors.ville[0] }}</p>
        </div>
      </div>

      <div class="mb-6">
        <label for="type_annonce" class="inline-block text-lg mb-2 required">Type d'annonce
        </label>
        <select @change="typeSelected" v-model="form.type_annonce" id="type_annonce"
          class="border border-gray-600 rounded p-2 w-full" name="type_annonce">
          <option selected value="">Choisir un type d'annonce</option>
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
        <label for="marque" class="inline-block text-lg mb-2 required">La Marque
        </label>
        <select v-model="form.marque_id" id="marque" class="border border-gray-600 rounded p-2 w-full" name="marque_id"
          @change="marqueSelected">
          <option selected value="">Choisir la marque de la voiture</option>
          <option v-for="marque in marqueResult" :key="marque.id" :value="marque.id">
            {{ marque.nom }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.marque_id">
            {{ errors.marque_id[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="modele" class="inline-block text-lg mb-2 required">Le Modele
        </label>
        <select v-model="form.modele_id" id="modele" class="border border-gray-600 rounded p-2 w-full" name="modele_id">
          <option selected value="" v-if="form.marque_id">Choisir le modele de la voiture</option>
          <option v-for="modele in modelesResult" :key="modele.id" :value="modele.id">
            {{ modele.nom }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.modele_id">
            {{ errors.modele_id[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="annee" class="inline-block text-lg mb-2 required">L'Annee de Fabrication
        </label>
        <select v-model="form.annee_fabrication" id="annee" class="border border-gray-600 rounded p-2 w-full"
          name="annee_fabrication">
          <option selected :value="null">Choisir l'annee</option>
          <option v-for="annee in annee_fabrication" :key="annee" :value="annee">
            {{ annee }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.annee_fabrication">
            {{ errors.annee_fabrication[0] }}
          </p>
        </div>
      </div>
      <!-- <div class="mb-6">
        <label for="etat" class="inline-block text-lg mb-2 required"
          >L'etat de la Voiture
        </label>
        <select
          v-model="form.etat"
          id="etat"
          class="border border-gray-600 rounded p-2 w-full"
          name="etat"
        >
          <option selected value="">Choisir l'etat de la Voiture</option>
          <option value="neuf">Neuf</option>
          <option value="occasion">Occasion</option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.etat">
            {{ errors.etat[0] }}
          </p>
        </div>
      </div> -->
      <div class="mb-6">
        <label for="carburant" class="inline-block text-lg mb-2 required">Carburant
        </label>
        <select v-model="form.carburant" id="carburant" class="border border-gray-600 rounded p-2 w-full"
          name="carburant">
          <option selected value="">Carburant</option>
          <option value="diesel">Diesel</option>
          <option value="essence">Essence</option>
          <option value="hybride">Hybride</option>
          <option value="electrique">Electrique</option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.carburant">
            {{ errors.carburant[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="kilometrage" class="inline-block text-lg mb-2 required">Kilometrage</label>
        <div class="inputField flex items-center">
          <input v-model="form.kilometrage" id="kilometrage" type="number"
            class="border border-gray-600 rounded-l p-2 w-full" name="kilometrage" placeholder="10000" />
          <div class="unit border border-gray-600 rounded-r p-2 min-w-12 max-w-12 bg-gray-300 text-gray-900">
            <p>KM</p>
          </div>
        </div>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.kilometrage">
            {{ errors.kilometrage[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="prix" class="inline-block text-lg mb-2 required">Prix</label>
        <div class="type" v-if="form.type_annonce == 'vente'">
          <div class="inputField flex items-center">
            <input v-model="form.prix_vente" id="prix" type="number" class="border border-gray-600 rounded-l p-2 w-full"
              name="prix_vente" placeholder="100000" />
            <div class="unit border border-gray-600 rounded-r p-2 bg-gray-300 text-gray-900 min-w-12 max-w-12">
              <p>DHS</p>
            </div>
          </div>
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.prix_vente">
              {{ errors.prix_vente[0] }}
            </p>
          </div>
        </div>
        <div class="type" v-else-if="form.type_annonce == 'location'">
          <div class="inputField flex">
            <input v-model="form.prix_location" id="prix" type="number"
              class="border border-gray-600 rounded-l p-2 w-full" name="prix_location" placeholder="100" />
            <div class="unit border border-gray-600 rounded-r p-2 bg-gray-300 text-gray-900 w-auto min-h-full">
              <p class="text-sm w-max">DHS / Jour</p>
            </div>
          </div>
          <div class="errors" v-if="errors">
            <p class="text-red-600" v-if="errors.prix_location">
              {{ errors.prix_location[0] }}
            </p>
          </div>
        </div>
        <div class="type" v-else>
          <div class="inputField flex">
            <input id="prix"
              class="border border-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed rounded-l p-2 w-full"
              value="Veuillez choisir un type d'annonce" disabled />
          </div>
        </div>
      </div>

      <div class="mb-6">
        <button type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress">
          Créer l'annonce
        </button>
      </div>
    </form>
    <div class="errors max-w-lg text-center mx-auto mb-10 mt-10" v-if="serverError">
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
import getModeles from "@/Composables/getModeles";

const serverError = ref("");
const form = ref({
  titre: null,
  description: null,
  ville: null,
  carburant: "",
  type_annonce: "",
  marque_id: "",
  modele_id: "",
  etat: "occasion",
  kilometrage: 0,
  couleur: null,
  annee_fabrication: null,
  options: [],
  prix_vente: null,
  prix_location: null,
  disponibilite_vente: null,
  disponibilite_location: null,
  images: [],
});

const errors = ref(null);
// Fetching Marques
const { marqueResult, ErrorMarque, loadMarque } = getMarques();
loadMarque();
serverError.value += Error.value || "";
// end marques

// Fetching Modeles after selecting marque
const { modelesResult, ErrorModele, loadModele } = getModeles(form.value.marque_id);
const marqueSelected = () => {
  modelesResult.value = [];
  if (form.value.marque_id) {
    loadModele(form.value.marque_id);
  }
}
// end Fetching Modeles

// on mounted set years since 1970
const annee_fabrication = ref([]);
for (let i = 1970; i <= new Date().getFullYear(); i++) {
  annee_fabrication.value.push(i);
}

// Handling Selecting types
const typeSelected = () => {
  if (form.value.type_annonce == "vente") {
    form.value.disponibilite_vente = true;
    form.value.disponibilite_location = null;
    // for price
    form.value.prix_vente = 0;
    form.value.prix_location = null;
  } else if (form.value.type_annonce == "location") {
    form.value.disponibilite_location = true;
    form.value.disponibilite_vente = null;
    // for price
    form.value.prix_location = 0;
    form.value.prix_vente = null;
  }
};
</script>

<style scoped>
.required:after {
  content: " *";
  color: red;
}
</style>
