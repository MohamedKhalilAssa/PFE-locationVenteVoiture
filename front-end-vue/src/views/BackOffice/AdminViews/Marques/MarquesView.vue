<template>
  <button
    class="bg-green-700 text-white rounded py-2 px-4 mx-auto my-6 hover:bg-green-800 duration-75 disabled:opacity-70 disabled:cursor-progress"
  >
    <router-link :to="{ name: 'ajouterMarque' }">
      Ajouter une Marque+
    </router-link>
  </button>
  <div
    class="relative overflow-auto shadow-lg sm:rounded-lg sm:!max-h-full"
    style="max-height: 80vh"
  >
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
        <tr
          class="bg-white border-b"
          v-if="marqueResult"
          v-for="marque in marqueResult"
          :key="marque.id"
        >
          <th
            scope="row"
            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
          >
            {{ marque.id }}
          </th>
          <td class="px-6 py-4">{{ marque.nom }}</td>
          <!-- <td class="px-6 py-4">Laptop</td> -->
          <td class="px-6 py-4 space-x-4">
            <router-link
              :to="{ name: 'modifierMarque', params: { id: marque.id } }"
              class="font-medium text-blue-600 hover:underline"
              >Modifier</router-link
            >
            <form
              method="post"
              @submit.prevent="deleteMarque(marque.id)"
              class="inline-block font-medium text-red-600"
            >
              <button type="submit" class="hover:underline">Supprimer</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import getMarques from "@/Composables/getMarques";
import axios from "axios";
import Swal from "sweetalert2";

// fetching marques
const { marqueResult, ErrorMarque, loadMarque } = getMarques();
loadMarque();
// deleting marque
const deleteMarque = async (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      // Send a delete request to the server
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        // Send the FormData object to the server using axios
        await axios.delete("http://localhost:8000/api/marque/" + id);

        loadMarque();
        Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
        });
      } catch (error) {
        Swal.fire({
          title: "Error!",
          text: "Failed to delete the marque.",
          icon: "error",
        });
      }
    }
  });
};
</script>
