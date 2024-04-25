import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import addCredentials from "@/Composables/AuthenticationRequests/addCredentials";
import router from "@/router";
import store from "@/store";

const forgotPassword = async (button, email, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.post(Endpoints.config__send_password_reset_link, {
      email: email.value,
    });

    store.commit(
      "setMessage",
      "Password reset link has been sent to your email"
    );
    // storing the data
    router.push({
      name: `homeView`,
    });
  } catch (error) {
    button.disabled = false;
    if (error.response) {
      if (error.response.status == 429) {
        store.commit("setError", "Too many requests. Please try again later.");
      } else if (error.response.status != 422) {
        store.commit("setError", error);
      } else {
        errors.value = error.response.data.errors ?? null;
      }
    }
  }
};

export default forgotPassword;
