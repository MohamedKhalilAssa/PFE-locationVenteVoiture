import Endpoints from "@/assets/JS/Endpoints";
import axios from "axios";
import addCredentials from "@/Composables/AuthenticationRequests/addCredentials";
import router from "@/router";
import store from "@/store";

const register = async (button, form, errors) => {
  try {
    if (button) button.disabled = true;

    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    const registerResponse = await axios.post(Endpoints.config__register, {
      nom: form.value.nom,
      prenom: form.value.prenom,
      telephone: form.value.telephone,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.password_confirmation,
    });

    if (registerResponse && registerResponse.data) {
      store.commit("setMessage", registerResponse.data.message);
    }

    const authenticatedUserResponse = await axios.get(
      Endpoints.config__get_authenticated_user
    );
    const data = authenticatedUserResponse.data;

    addCredentials(data);

    router.push({ name: "homeView", query: { message: "loggedIn" } });
  } catch (error) {
    if (button) button.disabled = false;

    if (error.response) {
      if (error.response.status === 429) {
        store.commit("setError", "Too many requests. Please try again later.");
      } else if (error.response.status !== 422) {
        store.commit("setError", error);
      } else {
        errors.value = error.response.data.errors ?? null;
      }
    } else {
      console.error("An unexpected error occurred:", error);
    }
  }
};

export default register;
