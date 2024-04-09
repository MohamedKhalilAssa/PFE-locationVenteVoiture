import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
import store from "@/store";

const getCSRFToken = async () => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get(Endpoints.config__get_csrf_token);
    if (
      localStorage.getItem("Authentication")
    ) {
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        const { data } = await axios.get(
          Endpoints.config__get_authenticated_user
        );

        if (data) {
          // make sure data present:
          // storing the data
          localStorage.setItem("Authentication", true);
          localStorage.setItem("User", JSON.stringify(data));
          sessionStorage.setItem("verified", true);
          store.commit("setAuthentication");
          store.commit("setUser");
        }
      } catch (error) {
        if (error) {
          store.commit("setError", error);
        }
        removeCredentials();
        window.location.reload();
      }
    }
  } catch (error) {
    if (error) {
      store.commit("setError", error);
    }
  }
};

export default getCSRFToken;
