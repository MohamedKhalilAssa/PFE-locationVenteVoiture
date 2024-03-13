<template>
  <button
    class="bg-green-700 text-white rounded py-2 px-4 mx-auto my-6 hover:bg-green-800 duration-75 disabled:opacity-70 disabled:cursor-progress">
    <router-link :to="{ name: 'ajouterMarque' }">
      Ajouter une Marque+
    </router-link>
  </button>
  <div class="relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full" style="max-height: 75vh">
    <table class="w-full text-sm text-center text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th scope="col" class="px-6 py-3">ID</th>
          <th scope="col" class="px-6 py-3">Nom de la Marque</th>
          <!-- <th scope="col" class="px-6 py-3">Logo</th> -->
          <th scope="col" class="px-6 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-white border-b" v-if="marqueResult" v-for="marque in marqueResult.data" :key="marque.id">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
            {{ marque.id }}
          </th>
          <td class="px-6 py-4">{{ marque.nom }}</td>
          <!-- <td class="px-6 py-4">Laptop</td> -->
          <td class="flex px-6 py-4 space-x-4 justify-center">
            <router-link
              :to="{ name: 'detailsMarque', params: { id: marque.id } }"
              class="font-medium text-black hover:underline"
              >Details</router-link
            >
            <router-link
              :to="{ name: 'modifierMarque', params: { id: marque.id } }"
              class="font-medium text-blue-600 hover:underline"
              >Modifier</router-link
            >
            <form
              method="post"
              @submit.prevent="DeleteFromDB(deletingEndpoint , marque.id,loadMarque)"
              class="inline-block font-medium text-red-600"
            >
              <button type="submit" class="hover:underline">Supprimer</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    <nav aria-label="Page navigation" class="m-5 text-center">
      <ul class="inline-flex -space-x-px text-sm">
        <li v-for="page in marqueResult.links">
          <button @click.self="pagination($event, page.url)" :disabled="page.url === null"
            :class="page.active ? '!text-blue-600  !border-blue-300 !bg-blue-50 hover:!bg-blue-100 hover:!text-blue-700' : ''"
            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white  border border-e-0 border-gray-300 hover:bg-gray-100 hover:text-gray-700 disabled:opacity-70 disabled:cursor-not-allowed"
            v-html="page.label"></button>
        </li>

      </ul>
    </nav>
  </div>
</template>

<script setup>
import getMarquesPaginate from "@/Composables/Getters/getMarquesPaginate";
import DeleteFromDB from "@/Composables/CRUDRequests/DeleteFromDB";

const deletingEndpoint = "http://localhost:8000/api/marque/";

// fetching marques  
const { marqueResult, ErrorMarque, loadMarque } = getMarquesPaginate();
loadMarque().then(() => {
  console.log(marqueResult.value);
});
const pagination = (e, page) => {
  const button = e.target;
  button.classList.add("!cursor-progress")
  if (page !== null) {
    button.classList.add = "!cursor-progress"
    const number = page.split("page=")[1];
    loadMarque(number).then(() => {
      button.classList.remove("!cursor-progress")
    });
  }
}
// deleting marque

</script>@/Composables/Getters/getMarquesPaginate
