import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
const getCSRFToken = async (store) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get(Endpoints.getCSRFToken);
    if (
      !sessionStorage.getItem("verified") &&
      localStorage.getItem("Authentication")
    ) {
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        const { data } = await axios.get(Endpoints.getAuthenticatedUser);

        if (data) {
          sessionStorage.setItem("verified", true);
          // make sure data present:
          // storing the data
          localStorage.setItem("Authentication", true);
          localStorage.setItem("User", JSON.stringify(data));
          store.commit("setAuthentication");
          store.commit("setUser");
        }
      } catch (error) {
        if (error) {
          store.commit("setError", error);
        }
        localStorage.removeItem("Authentication");
        localStorage.removeItem("User");
        localStorage.removeItem("authMessage");
        store.commit("setAuthentication");
        store.commit("setUser");
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
