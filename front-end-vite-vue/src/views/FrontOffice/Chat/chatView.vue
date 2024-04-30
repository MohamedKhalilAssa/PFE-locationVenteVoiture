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
        class="body relative bg-gray-200 overflow-auto sm:!max-h-96 rounded-lg p-2 h-full scroll-smooth"
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
        <div
          class="scrollDown sticky bottom-2 left-1 bg-white w-8 h-8 flex items-center justify-center cursor-pointer rounded-full"
          v-if="showScrollDown"
          @click="scrollToBottom"
        >
          <i class="fa-solid fa-angles-down"></i>
        </div>
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
import { ref, onMounted, onUnmounted, onUpdated, computed } from "vue";
import Endpoints from "@/assets/JS/Endpoints";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import { setFormData } from "@/Composables/Helpers/globalFunctions";
import getFromDB from "@/Composables/Getters/getFromDB";

const props = defineProps(["id"]);
const button = ref(null);
const errors = ref(null);
const messages = ref({});
const receiver = ref({});
const messagingBody = ref(null);
const scrolledDown = ref(false);

const form = ref({
  receiver_id: props.id,
  message: "",
});

const fetchMessages = async () => {
  getFromDB(Endpoints.chat__get_messages + props.id).then((response) => {
    messages.value = response;
  });
};
const submitMessage = async () => {
  const formData = setFormData(form);
  AddToDB(button.value, Endpoints.chat__message, formData, "", errors);
  fetchMessages();
  form.value.message = "";
};
let counter;
let showScrollDown;
onMounted(() => {
  // first fetch
  fetchMessages();
  getFromDB(Endpoints.user__get_or_update_or_delete + props.id).then(
    (response) => {
      receiver.value = response;
    }
  );
  // interval for regular fetch
  counter = setInterval(() => {
    fetchMessages();
  }, 4000);
  // computed value
});
onUpdated(() => {
  if (!scrolledDown.value) {
    scrollToBottom();
    scrolledDown.value = true;
  }
  showScrollDown = computed(() => {
    return messagingBody.value.scrollTop <= messagingBody.value.scrollHeight;
  });
  console.log(showScrollDown.value);
});
onUnmounted(() => {
  clearInterval(counter);
});

const scrollToBottom = () => {
  setTimeout(() => {
    messagingBody.value.scrollTop =
      messagingBody.value.scrollHeight - messagingBody.value.clientHeight;
  }, 0);
};
</script>
