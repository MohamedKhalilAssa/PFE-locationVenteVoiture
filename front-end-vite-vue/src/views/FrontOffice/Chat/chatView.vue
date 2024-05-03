<template>
  <main class="flex justify-center sm:p-4 mb-14 sm:mb-4">
    <div
      class="wrapper sm:h-max mt-14 p-2 sm:p-4 bg-white rounded-lg max-w-3xl w-full min-h-96 shadow-lg"
    >
      <div
        class="header w-full p-2 min-h-16 flex flex-wrap justify-between items-center sm:items-start"
      >
        <h3
          v-if="receiver"
          class="relative text-2xl mb-3 sm:mb-6 sm:text-3xl leading-6 font-medium tracking-tight text-gray-900 text-ellipsis overflow-hidden whitespace-nowrap block after:border-b-4 after:border-red-500 after:absolute after:left-0 after:bottom-1 after:w-8 pb-3"
        >
          {{ receiver.nom + " " + receiver.prenom }}
        </h3>
        <div
          class="status flex justify-end items-center gap-2 w-full sm:w-auto sm:pt-2"
          v-if="receiver"
        >
          <p class="pb-0.5">
            {{ receiver.status == "Online" ? "Online" : "Offline" }}
          </p>
          <i
            class="fa-solid fa-circle flex items-center"
            :class="
              receiver.status == 'Online' ? 'text-green-500' : 'text-red-500'
            "
          ></i>
        </div>
      </div>
      <div
        class="body relative bg-gray-200 overflow-auto sm:!max-h-96 sm:!min-h-96 rounded-lg p-2 h-full scroll-smooth"
        style="max-height: 60vh"
        ref="messagingBody"
      >
        <ul class="relative flex flex-col gap-2" v-if="messages && receiver">
          <div
            v-for="message in messages"
            :key="message.id"
            class="message-container flex"
            :class="
              message.sender_id == receiver.id ? 'justify-start' : 'justify-end'
            "
          >
            <li
              class="rounded-lg p-2 text-lg min-w-40 break-all"
              style="max-width: 80%"
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
          @click="scrollToBottom"
          v-if="showScroller"
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
import { defineProps, onMounted, onUnmounted, onUpdated, ref } from "vue";
import Endpoints from "@/assets/JS/Endpoints";
import AddToDB from "@/Composables/CRUDRequests/AddToDB";
import { setFormData } from "@/Composables/Helpers/globalFunctions";
import getFromDB from "@/Composables/Getters/getFromDB";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const button = ref(null);
const store = useStore();
const router = useRouter();
const errors = ref(null);
const messages = ref({});
const receiver = ref(null);
const messagingBody = ref(null);
const scrolledDown = ref(false);
const showScroller = ref(false);

const form = ref({
  receiver_id: props.id,
  message: "",
});

const fetchMessages = async () => {
  messages.value = await getFromDB(Endpoints.chat__get_messages + props.id);
};

const submitMessage = async () => {
  const formData = setFormData(form);
  await AddToDB(button.value, Endpoints.chat__message, formData, "", errors);
  scrollToBottom();
  messages.value.push({ receiver_id: props.id, message: form.value.message });
  form.value.message = "";
};

let counter;
onMounted(() => {
  if (form.value.receiver_id == store.getters.getUser.id) {
    router.push({ name: "homeView" });
  }

  fetchMessages();
  getFromDB(Endpoints.user__get_or_update_or_delete + props.id).then(
    (response) => {
      receiver.value = response;
      console.log(response);
    }
  );
  counter = setInterval(fetchMessages, 5000);
  if (messagingBody.value) {
    messagingBody.value.addEventListener("scroll", () => {
      showScroller.value =
        document.querySelector(".body").scrollTop <
        document.querySelector(".body").scrollHeight -
          document.querySelector(".body").clientHeight -
          50;
    });
  }
});

onUpdated(() => {
  if (
    !scrolledDown.value &&
    messagingBody.value &&
    receiver.value &&
    messages.value
  ) {
    scrollToBottom();
    scrolledDown.value = true;
  }
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
