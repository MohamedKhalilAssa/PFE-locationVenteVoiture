<template>
  <section
    class="form bg-gray-200 flex justify-center items-center flex-col py-16 px-2 sm:px-16"
  >
    <form
      method="POST"
      @submit.prevent="uploadFiles"
      class="bg-white border border-gray-900 shadow-2xl p-5 md:p-10 rounded max-w-lg w-full"
      enctype="multipart/form-data"
    >
      <header class="text-center mb-7">
        <h2 class="text-2xl font-bold uppercase mb-1">Creer une annonce</h2>
      </header>

      <div class="mb-6">
        <label for="titre" class="inline-block text-lg mb-2 required"
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
          class="border border-gray-600 rounded p-2 w-full min-h-24"
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
          >La Ville
        </label>
        <select
          v-model="form.ville_id"
          id="ville"
          class="border border-gray-600 rounded p-2 w-full"
        >
          <option selected :value="null">La Ville</option>
          <option
            v-for="ville in villeResult"
            :key="ville.id"
            :value="ville.id"
          >
            {{ ville.nom }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.ville_id">
            {{ errors.ville_id[0] }}
          </p>
        </div>
      </div>

      <div class="mb-6">
        <label for="type_annonce" class="inline-block text-lg mb-2 required"
          >Type d'annonce
        </label>
        <select
          @change="typeSelected"
          v-model="form.type_annonce"
          id="type_annonce"
          class="border border-gray-600 rounded p-2 w-full"
          name="type_annonce"
        >
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
      <div class="mb-6" v-show="allowed">
        <label for="etat" class="inline-block text-lg mb-2 required"
          >Etat de voiture
        </label>
        <select
          @change="typeSelected"
          v-model="form.etat"
          id="etat"
          class="border border-gray-600 rounded p-2 w-full"
          name="type_annonce"
        >
          <option value="">Choisir l'etat de la voiture</option>
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
        <label for="marque" class="inline-block text-lg mb-2 required"
          >La Marque
        </label>
        <select
          v-model="form.marque_id"
          id="marque"
          class="border border-gray-600 rounded p-2 w-full"
          name="marque_id"
          @change="marqueSelected"
        >
          <option selected value="">Choisir la marque de la voiture</option>
          <option
            v-for="marque in marqueResult"
            :key="marque.id"
            :value="marque.id"
          >
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
        <label for="modele" class="inline-block text-lg mb-2 required"
          >Le Modele
        </label>
        <select
          v-model="form.modele_id"
          id="modele"
          class="border border-gray-600 rounded p-2 w-full"
          name="modele_id"
        >
          <option selected value="" v-if="form.marque_id">
            Choisir le modele de la voiture
          </option>
          <option
            v-for="modele in modelesResult"
            :key="modele.id"
            :value="modele.id"
          >
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
        <label for="annee" class="inline-block text-lg mb-2 required"
          >L'Annee de Fabrication
        </label>
        <select
          v-model="form.annee_fabrication"
          id="annee"
          class="border border-gray-600 rounded p-2 w-full"
          name="annee_fabrication"
        >
          <option selected :value="null">Choisir l'annee</option>
          <option
            v-for="annee in annee_fabrication"
            :key="annee"
            :value="annee"
          >
            {{ annee }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.annee_fabrication">
            {{ errors.annee_fabrication[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="carburant" class="inline-block text-lg mb-2 required"
          >Carburant
        </label>
        <select
          v-model="form.carburant"
          id="carburant"
          class="border border-gray-600 rounded p-2 w-full"
          name="carburant"
        >
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
        <label for="couleur" class="inline-block text-lg mb-2 required"
          >La Couleur
        </label>
        <select
          v-model="form.couleur_id"
          id="couleur"
          class="border border-gray-600 rounded p-2 w-full"
          name="couleur_id"
        >
          <option selected :value="null">
            Choisir la couleur de la voiture
          </option>
          <option
            v-for="couleur in couleurResult"
            :key="couleur.id"
            :value="couleur.id"
          >
            {{ couleur.nom }}
          </option>
        </select>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.couleur_id">
            {{ errors.couleur_id[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="kilometrage" class="inline-block text-lg mb-2 required"
          >Kilometrage</label
        >
        <div class="inputField flex items-center">
          <input
            v-model="form.kilometrage"
            id="kilometrage"
            type="number"
            class="border border-gray-600 rounded-l p-2 w-full"
            name="kilometrage"
            placeholder="10000"
          />
          <div
            class="unit border border-gray-600 rounded-r p-2 min-w-12 max-w-12 bg-gray-300 text-gray-900"
          >
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
        <label for="prix" class="inline-block text-lg mb-2 required"
          >Prix</label
        >
        <div class="type" v-if="form.type_annonce == 'vente'">
          <div class="inputField flex items-center">
            <input
              v-model="form.prix_vente"
              id="prix"
              type="number"
              class="border border-gray-600 rounded-l p-2 w-full"
              name="prix_vente"
              placeholder="100000"
            />
            <div
              class="unit border border-gray-600 rounded-r p-2 bg-gray-300 text-gray-900 min-w-12 max-w-12"
            >
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
            <input
              v-model="form.prix_location"
              id="prix"
              type="number"
              class="border border-gray-600 rounded-l p-2 w-full"
              name="prix_location"
              placeholder="100"
            />
            <div
              class="unit border border-gray-600 rounded-r p-2 bg-gray-300 text-gray-900 w-auto min-h-full"
            >
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
            <input
              id="prix"
              class="border border-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed rounded-l p-2 w-full"
              value="Veuillez choisir un type d'annonce"
              disabled
            />
          </div>
        </div>
      </div>
      <div class="mb-6">
        <label for="" class="inline-block text-lg mb-2"> Options </label>
        <div class="container flex flex-wrap justify-center options space-y-3">
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option1"
              name="option[]"
              value="toutes_options"
              @change="toggleAllOptions"
              v-model="form.options"
            />
            <label for="option1" class="ml-2">Toutes options</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option2"
              name="option[]"
              value="GPS"
              v-model="form.options"
            />
            <label for="option2" class="ml-2">GPS</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option3"
              name="option[]"
              value="Sieges_chauffants"
              v-model="form.options"
            />
            <label for="option3" class="ml-2">Sièges chauffants</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option4"
              value="Camera_recul"
              name="option[]"
              v-model="form.options"
            />
            <label for="option4" class="ml-2">Caméra de recul</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option5"
              value="Regulateur_vitesse"
              name="option[]"
              v-model="form.options"
            />
            <label for="option5" class="ml-2">Régulateur de vitesse</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option6"
              name="option[]"
              value="Ordinateur_de_bord"
              v-model="form.options"
            />
            <label for="option6" class="ml-2">Ordinateur de bord</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option7"
              name="option[]"
              value="ABS"
              v-model="form.options"
            />
            <label for="option7 " class="ml-2">Abs</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option8"
              name="option[]"
              value="Vitres_electriques"
              v-model="form.options"
            />
            <label for="option8 " class="ml-2">Vitres éléctriques</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option9"
              name="option[]"
              value="Airbags"
              v-model="form.options"
            />
            <label for="option9 " class="ml-2">Airbags</label>
          </div>
          <div class="option flex items-center space-x-2">
            <input
              type="checkbox"
              id="option10"
              name="option[]"
              value="Anti_brouillard"
              v-model="form.options"
            />
            <label for="option10 " class="ml-2">Anti brouillard</label>
          </div>
        </div>

        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.options">
            {{ errors.options[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6">
        <label for="image" class="inline-block text-lg mb-2 required"
          >Images</label
        >
        <div class="afficherImages border border-gray-200 rounded p-2 w-full">
          <label>
            <p
              class="text-center bg-red-500 w-max p-3 text-white my-4 mx-auto cursor-pointer hover:bg-red-700"
            >
              Ajouter des images+
            </p>
            <input
              @change="handleFileChange"
              type="file"
              class="w-full hidden"
              name="image"
              id="image"
              multiple
            />
          </label>

          <div
            class="inserted flex justify-between mx-3"
            v-for="image in files"
            :key="image.id"
          >
            <p
              class="tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap"
            >
              {{ image.file.name }}
            </p>
            <button
              class="outline-none border-none"
              @click="removeFile(image.id)"
            >
              <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="errors" v-if="errors">
          <p class="text-red-600" v-if="errors.image">
            {{ errors.image[0] }}
          </p>
        </div>
      </div>
      <div class="mb-6 flex justify-center items-center">
        <button
          ref="submitButton"
          type="submit"
          class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Créer l'annonce
        </button>
      </div>
    </form>
  </section>
</template>

<script setup>
import { computed, ref } from "vue";
import { useStore } from "vuex";
import Endpoints from "@/assets/JS/Endpoints";
import getFromDB from "@/Composables/Getters/getFromDB";
import { setForm, setFormData } from "@/Composables/Helpers/globalFunctions";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";

const store = useStore();
const errors = ref(null);
const submitButton = ref(null);
const allowed = computed(() => {
  return (
    store.getters.getUser.role == "root" ||
    store.getters.getUser.role == "admin"
  );
});
const form = ref({
  titre: "",
  description: "",
  ville_id: null,
  carburant: "",
  type_annonce: "",
  marque_id: "",
  modele_id: "",
  couleur_id: null,
  kilometrage: 0,
  annee_fabrication: null,
  etat: allowed.value ? "" : "occasion",
  options: [],
  prix_vente: null,
  prix_location: null,
  disponibilite_vente: null,
  disponibilite_location: null,
});

// handling images
const files = ref([]);
const handleFileChange = (e) => {
  files.value.push({ id: Date.now().toString(36), file: e.target.files[0] });
};
const removeFile = (id) => {
  files.value = files.value.filter((file) => file.id != id);
};
// end image

const uploadFiles = async () => {
  let formData = setFormData(form, "options");

  // storing images in formData
  files.value.forEach((file) => {
    formData.append("image[]", file.file);
  });
  // storing options in formData
  form.value.options.forEach((value, index) => {
    formData.append("options[]", value);
  });

  let redirectTo =
    form.value.type_annonce == "location"
      ? "locationFrontView"
      : form.value.type_annonce == "vente"
      ? "occasionFrontView"
      : "homeView";
  AddToDB(
    submitButton.value,
    Endpoints.occasion__add,
    formData,
    redirectTo,
    errors
  );
};
/**
 * fetching begins here
 * fetching marque modele couleur ville
 */

const marqueResult = ref([]);
const modelesResult = ref([]);
const couleurResult = ref([]);
const villeResult = ref([]);

// Fetching Marques
getFromDB(Endpoints.marque__get_all_or_add).then((response) => {
  if (response) {
    marqueResult.value = response;
  }
});
// end marques

// Fetching Modeles after selecting marque
const marqueSelected = () => {
  modelesResult.value = [];
  if (form.value.marque_id) {
    getFromDB(Endpoints.modele__get_by_marque + form.value.marque_id).then(
      (response) => {
        if (response) {
          modelesResult.value = response;
        }
      }
    );
  }
};
// end Fetching Modeles
// fetching color
getFromDB(Endpoints.couleur__get_all_or_add).then((response) => {
  if (response) {
    couleurResult.value = response;
  }
});
// end fetch

// fetching villes
getFromDB(Endpoints.ville__get_all_or_add).then((response) => {
  if (response) {
    villeResult.value = response;
  }
});

// on mounted set years since 1970
const annee_fabrication = ref([]);
for (let i = 1970; i <= new Date().getFullYear(); i++) {
  annee_fabrication.value.push(i);
}
// end years

// Handling Options
const toggleAllOptions = (e) => {
  if (e.target.checked) {
    form.value.options = ["toutes_options"];
    document
      .querySelectorAll(".option input:not(#option1)")
      .forEach((element) => {
        element.disabled = true;
      });
  } else {
    document
      .querySelectorAll(".option input:not(#option1)")
      .forEach((element) => {
        element.disabled = false;
      });
  }
};
// end option
// Handling Selecting types
const typeSelected = () => {
  if (form.value.type_annonce == "vente") {
    form.value.disponibilite_vente = "disponible";
    form.value.disponibilite_location = null;
    // for price
    form.value.prix_vente = 0;
    form.value.prix_location = null;
  } else if (form.value.type_annonce == "location") {
    form.value.disponibilite_location = "disponible";
    form.value.disponibilite_vente = null;
    // for price
    form.value.prix_location = 0;
    form.value.prix_vente = null;
  }
};
</script>

<style>
.required:after {
  content: " *";
  color: red;
}

.options {
  gap: 3%;
}

.option {
  width: calc(94% / 2);
}

@media screen and (max-width: 568px) {
  .option {
    width: 100%;
    margin-bottom: 0.4rem;
  }

  .option input {
    width: 1.1rem;
    height: 1.1rem;
  }

  .option label {
    font-size: 1.2rem;
    padding-bottom: 3px;
  }
}
</style>
