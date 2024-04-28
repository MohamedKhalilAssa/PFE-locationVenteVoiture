import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import addCredentials from "@/Composables/AuthenticationRequests/addCredentials";
import router from "@/router";
import store from "@/store";

const login = async (button, form, route, errors) => {
  try {
    if (button) button.disabled = true;

    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    const loginResponse = await axios.post(Endpoints.config__login, {
      email: form.value.email,
      password: form.value.password,
    });

    if (loginResponse && loginResponse.data) {
      store.commit("setMessage", loginResponse.data.message);
    }

    const authenticatedUserResponse = await axios.get(
      Endpoints.config__get_authenticated_user
    );
    const data = authenticatedUserResponse.data;

    addCredentials(data);

    if (data.role === "admin" || data.role === "root") {
      router.push({ name: "adminHome" });
    } else if (route.query.previous) {
      router.push({ name: route.query.previous });
    } else {
      router.push({ name: "homeView" });
    }
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

export default login;
