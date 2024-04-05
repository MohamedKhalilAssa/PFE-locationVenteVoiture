import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
const getCSRFToken = async (store) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get(Endpoints.getCSRFToken);
    if (
      localStorage.getItem("Authentication")
    ) {
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        const { data } = await axios.get(Endpoints.getAuthenticatedUser);

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
