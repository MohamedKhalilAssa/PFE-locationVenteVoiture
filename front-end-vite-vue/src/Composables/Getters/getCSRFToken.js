import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
import store from "@/store";

const getCSRFToken = async () => {
  try {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    await axios.get(Endpoints.config__get_csrf_token);

    if (localStorage.getItem("Authentication")) {
      const { data } = await axios.get(
        Endpoints.config__get_authenticated_user
      );

      if (data) {
        localStorage.setItem("Authentication", true);
        localStorage.setItem("User", JSON.stringify(data));
        sessionStorage.setItem("verified", true);
        store.commit("setAuthentication");
        store.commit("setUser");
      }
    }
  } catch (error) {
    if (error.response) {
      store.commit("setError", error);
      removeCredentials();
      window.location.reload();
    } else {
      console.error("An unexpected error occurred:", error);
      store.commit("setError", error);
    }
  }
};

export default getCSRFToken;
