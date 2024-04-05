import Endpoints from "@/assets/JS/Endpoints";
import axios from "axios";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";

const logout = async (store, route, router) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.post(Endpoints.logout).then((response) => {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    });
    if (route.meta.requiresAuth) {
      router.push({ name: "home" });
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
