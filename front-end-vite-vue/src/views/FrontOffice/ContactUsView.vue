<template>
  <main class="flex justify-center items-center p-6">
    <div class="container max-w-3xl bg-white">
      <form @submit.prevent="submitMessage">
        <label for="fullname">Full Name</label>
        <input
          type="text"
          id="fullname"
          name="fullname"
          v-model="form.full_name"
          placeholder="Your name.."
        />
        <div class="errors mb-4" v-if="errors">
          <p class="text-red-600" v-if="errors.full_name">
            {{ errors.full_name[0] }}
          </p>
        </div>
        <label for="email">Email</label>
        <input
          type="text"
          id="email"
          placeholder="Your Email.."
          v-model="form.email"
        />
        <div class="errors mb-4" v-if="errors">
          <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>

        <label for="email">Object</label>
        <input
          type="text"
          id="objet"
          placeholder="Object..."
          v-model="form.object"
        />
        <div class="errors mb-4" v-if="errors">
          <p class="text-red-600" v-if="errors.object">
            {{ errors.object[0] }}
          </p>
        </div>
        <label for="message">Message</label>
        <textarea
          id="message"
          name="message"
          placeholder="Write something.."
          style="height: 200px"
          v-model="form.message"
        ></textarea>
        <div class="errors mb-4" v-if="errors">
          <p class="text-red-600" v-if="errors.message">
            {{ errors.message[0] }}
          </p>
        </div>
        <button
          ref="button"
          class="bg-red-500 text-white rounded py-2 px-4 hover:scale-105 mt-3 duration-300 disabled:opacity-70 disabled:cursor-progress"
        >
          Submit
        </button>
      </form>
    </div>
  </main>
</template>
<script setup>
import { ref } from "vue";
import { setFormData } from "@/Composables/Helpers/globalFunctions";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import Endpoints from "@/assets/JS/Endpoints";

const button = ref(null);
const errors = ref(null);
const form = ref({
  full_name: "",
  email: "",
  object: "",
  message: "",
});

const submitMessage = async () => {
  const formData = setFormData(form);
  await AddToDB(
    button.value,
    Endpoints.contact__store,
    formData,
    "",
    errors
  ).then((resp) => {
    console.log(resp);
    if (resp) {
      form.value.message = "";
      form.value.full_name = "";
      form.value.email = "";
      form.value.object = "";
    }
  });
};
</script>
<style scoped src="@/assets/css/contactus.css"></style>
