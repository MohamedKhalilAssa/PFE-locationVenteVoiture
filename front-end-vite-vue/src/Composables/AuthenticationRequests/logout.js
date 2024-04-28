import Endpoints from "@/assets/JS/Endpoints";
import axios from "axios";
import router from "@/router";
import store from "@/store";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";

const logout = async (route) => {
  try {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    const response = await axios.post(Endpoints.config__logout);

    if (response && response.data) {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    }

    if (route.meta.requiresAuth) {
      router.push({ name: "homeView" });
    }

    removeCredentials();
  } catch (error) {
    if (error) {
      store.commit("setError", error);
    }
    removeCredentials();
  }
};
export default logout;
