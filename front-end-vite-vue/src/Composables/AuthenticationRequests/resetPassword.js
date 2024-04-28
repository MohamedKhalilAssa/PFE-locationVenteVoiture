import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import addCredentials from "@/Composables/AuthenticationRequests/addCredentials";
import router from "@/router";
import store from "@/store";

const resetPassword = async (button, passwords, errors) => {
  try {
    if (button) button.disabled = true;

    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    await axios.post(Endpoints.config__reset_password, {
      password: passwords.value.password,
      password_confirmation: passwords.value.password_confirmation,
      token: passwords.value.token,
      email: passwords.value.email,
    });

    store.commit("setMessage", "Modification de votre mot de passe réussie");
    // Storing the data
    router.push({ name: "Login" });
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

export default resetPassword;
