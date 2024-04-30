<template>
  <main class="flex justify-center p-4">
    <div
      class="mt-10 p-4 content flex flex-col justify-center items-center w-80 bg-white rounded-lg h-80"
    >
      <div class="header">
        <h1>Pusher Test</h1>
        <p>
          Publish an event to channel <code>my-channel</code> with event name
          <code>my-event</code>; it will appear below:
        </p>
        <!-- <ul>
          <li v-for="message in messages" :key="message.id">
            {{ message.text }}
          </li>
        </ul> -->
      </div>
      <div class="form">
        <form @submit.prevent="submitMessage">
          <input type="text bg-gray-500" v-model="form.message" />
          <button ref="button" type="submit">Submit</button>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import { useStore } from "vuex";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import { setFormData } from "@/Composables/Helpers/globalFunctions";

const props = defineProps(["id"]);
const button = ref(null);
const errors = ref(null);
const form = ref({
  receiver_id: props.id,
  message: "",
});
const submitMessage = async () => {
  const formData = setFormData(form);
  AddToDB(button.value, Endpoints.chat__message, formData, "", errors);
  form.value.message = "";
};

// // Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;
// const store = useStore();
// const messages = ref([]);
// const message = ref("");

// onMounted(() => {
//   const pusher = new Pusher("4c8637a085e3c6ecffb9", {
//     cluster: "eu",
//   });

//   const channel = pusher.subscribe("chat");
//   channel.bind("message", (data) => {
//     messages.value.push(data);
//   });
// });

// const submitMessage = async () => {
//   axios.post(Endpoints.chat__message, {
//     email: store.getters.getUser.email,
//     message: message.value,
//   });

//   message.value = "";
// };
</script>
