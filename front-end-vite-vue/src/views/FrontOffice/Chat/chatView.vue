<template>
  <main class="flex justify-center p-4">
    <div
      class="wrapper sm:h-max mt-14 p-4 bg-white rounded-lg max-w-3xl w-full min-h-96 shadow-lg"
    >
      <div class="header">
        <h3
          class="relative text-2xl mb-6 sm:text-3xl leading-6 font-medium tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap block after:border-b-4 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-8 pb-2"
        >
          {{ receiver.nom + " " + receiver.prenom }}
        </h3>
      </div>
      <div
        class="body bg-gray-200 overflow-auto sm:!max-h-96 rounded-lg p-2 h-full"
        style="max-height: 60vh"
        ref="messagingBody"
      >
        <ul class="relative flex flex-col gap-2" v-if="messages">
          <div
            v-for="message in messages"
            :key="message.id"
            class="message-container flex"
            :class="
              message.sender_id == receiver.id ? 'justify-start' : 'justify-end'
            "
          >
            <li
              class="rounded-lg p-2 text-lg w-80 min-w-40 break-all"
              :class="
                message.sender_id == receiver.id
                  ? ' bg-red-500 text-white'
                  : ' bg-white text-black'
              "
            >
              {{ message.message }}
            </li>
          </div>
        </ul>
      </div>
      <div class="sendMessage w-full h-16 mt-6">
        <form
          @submit.prevent="submitMessage"
          class="w-full h-full flex items-center"
        >
          <input
            type="text"
            v-model="form.message"
            placeholder="Send Message..."
            class="w-full h-3/4 bg-white rounded-lg p-2 border-2 shadow-sm"
          />
          <button
            ref="button"
            class="w-max flex items-center gap-2 p-2 m-2 h-3/4 bg-red-500 rounded-md text-white"
            type="submit"
          >
            <i class="fa-solid fa-paper-plane"></i>
            <p>Submit</p>
          </button>
        </form>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Endpoints from "@/assets/JS/Endpoints";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import { setFormData } from "@/Composables/Helpers/globalFunctions";
import getFromDB from "@/Composables/Getters/getFromDB";
import { useStore } from "vuex";
import axios from "axios";
Pusher.logToConsole = true;

const props = defineProps(["id"]);
const button = ref(null);
const errors = ref(null);
const messages = ref({});
const store = useStore();
const receiver = ref({});
const messagingBody = ref(null);

const form = ref({
  receiver_id: props.id,
  message: "",
});

const fetchMessages = async () => {
  getFromDB(Endpoints.chat__get_messages + props.id).then((response) => {
    messages.value = response;
    setTimeout(() => {
      messagingBody.value.scrollTop =
        messagingBody.value.scrollHeight - messagingBody.value.clientHeight;
    }, 0);
  });
};
const submitMessage = async () => {
  const formData = setFormData(form);
  AddToDB(button.value, Endpoints.chat__message, formData, "", errors);
  fetchMessages();

  form.value.message = "";
};
axios;
onMounted(() => {
  const token = ref();
  if (!localStorage.getItem("BearerToken")) {
    axios.get(Endpoints.config__get_bearer_token).then((response) => {
      token.value = response.data.token;
      localStorage.setItem("BearerToken", token.value);
    });
  } else {
    token.value = localStorage.getItem("BearerToken");
  }
  const pusher = new Pusher("4c8637a085e3c6ecffb9", {
    cluster: "eu",
    authEndpoint: Endpoints.pusher__auth,
    auth: {
      headers: {
        Authorization: "Bearer " + token.value,
        "Access-Control-Allow-Origin": "*",
      },
    },
  });
  var channel = pusher.subscribe(
    `private-message-channel.${store.getters.getUser.id}`
  );

  channel.bind(`message-sent`, function (event) {
    // Callback function to handle the event
    console.log(event);
  });

  getFromDB(Endpoints.user__get_or_update_or_delete + props.id).then(
    (response) => {
      receiver.value = response;
    }
  );
  fetchMessages();
});
// // Enable pusher logging - don't include this in production
// const messages = ref([]);
// const message = ref("");

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
