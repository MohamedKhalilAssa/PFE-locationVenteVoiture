import axios from "axios";

const getCSRFToken = async (store) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    if (
      !sessionStorage.getItem("verified") &&
      localStorage.getItem("Authentication")
    ) {
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        const { data } = await axios.get("http://localhost:8000/api/user");

        if (data) {
          sessionStorage.setItem("verified", true);
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
