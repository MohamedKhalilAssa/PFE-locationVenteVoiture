<template>
  <main>
    <Hero />
    <section class="w-full p-4 md:p-8 mb-20" style="max-height: 70vh">
      <p class="text-3xl font-bold text-center uppercase">Comment ça marche</p>
      <div
        class="steps mt-20 flex justify-around items-center gap-12 flex-col sm:flex-row"
      >
        <div class="step flex flex-col items-center gap-2">
          <div
            class="icon text-red-500 bg-gray-100 w-10 h-10 p-10 rounded-full flex justify-center items-center"
          >
            <i class="fa-solid fa-car text-3xl"></i>
          </div>
          <p class="text-xl font-semibold">Chercher une voiture</p>
          <p class="text-gray-500 max-w-96 text-center">
            facilement et rapidement trouver une voiture qui vous convient
          </p>
        </div>
        <div class="step flex flex-col items-center gap-2">
          <div
            class="icon text-red-500 bg-gray-100 w-10 h-10 p-10 rounded-full flex justify-center items-center"
          >
            <i class="fa-solid fa-message text-3xl"></i>
          </div>
          <p class="text-xl font-semibold">Contacter le vendeur</p>
          <p class="text-gray-500 max-w-96 text-center">
            Contacter le vendeur pour un rendez-vous ou vous acheterez votre
            voiture
          </p>
        </div>
      </div>
    </section>
    <section class="w-full p-4 md:p-8 mb-20" style="max-height: 70vh">
      <p class="text-3xl font-bold text-center uppercase">
        Parcourir les annonces
      </p>
      <div
        class="steps mt-20 flex justify-around items-center gap-12 flex-col sm:flex-row"
      >
        <router-link :to="{ name: 'neufFrontView' }">
          <div class="step flex flex-col items-center gap-2">
            <div
              class="icon text-red-500 bg-gray-100 w-10 h-10 p-10 rounded-full flex justify-center items-center"
            >
              <i class="fa-solid fa-car-on text-3xl"></i>
            </div>
            <p class="text-xl font-semibold">Neuves</p>
            <p class="text-gray-500 max-w-96 text-center">
              Voitures jamais utilisees parmi une grande selection
            </p>
          </div>
        </router-link>
        <router-link :to="{ name: 'occasionFrontView' }">
          <div class="step flex flex-col items-center gap-2">
            <div
              class="icon text-red-500 bg-gray-100 w-10 h-10 p-10 rounded-full flex justify-center items-center"
            >
              <i class="fa-solid fa-car-burst text-3xl"></i>
            </div>
            <p class="text-xl font-semibold">Occasion</p>
            <p class="text-gray-500 max-w-96 text-center">
              Voiture deja utilisee mais toujours en bon etat
            </p>
          </div>
        </router-link>
        <router-link :to="{ name: 'locationFrontView' }">
          <div class="step flex flex-col items-center gap-2">
            <div
              class="icon text-red-500 bg-gray-100 w-10 h-10 p-10 rounded-full flex justify-center items-center"
            >
              <i class="fa-solid fa-stopwatch text-3xl"></i>
            </div>
            <p class="text-xl font-semibold">Location</p>
            <p class="text-gray-500 max-w-96 text-center">
              Louer la voiture de votre choix en toute simplicité
            </p>
          </div>
        </router-link>
      </div>
    </section>
    <section class="w-full p-4 md:p-8" style="min-height: 50vh">
      <p class="text-3xl font-bold text-center uppercase">Contactez-nous</p>

      <div class="ml-10 mt-20 container flex items-center justify-center gap-6">
        <a
          :href="`mailto:support@email.com`"
          class="flex items-center h-16 gap-2 bg-transparent rounded-lg border w-36 border-black text-black hover:bg-red-500 hover:border-red-500 hover:text-white duration-300 transition-all py-2 px-4 focus:outline-none focus:shadow-outline"
        >
          <i class="fa-regular text-xl fa-envelope"></i>
          Email
        </a>
        <a
          class="whatsapp h-16 w-36 flex items-center !rounded-lg justify-center"
          :href="`https://wa.me/+21260000000`"
          ><i class="fa-brands text-xl fa-whatsapp pr-2"></i>Whatsapp
        </a>
      </div>
    </section>
  </main>
</template>
<style src="@/assets/css/detailsAnnonceFront.css"></style>

<script setup>
import Hero from "@/Components/HeroSection.vue";
</script>
<style scoped></style>
