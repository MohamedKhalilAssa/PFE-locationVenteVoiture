import axios from "axios";

export default async function VerifyAuth(store) {
  if (
    !sessionStorage.getItem("verified") &&
    localStorage.getItem("Authentication")
  ) {
    console.log("verifying auth...");
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      const { data } = await axios.get("http://localhost:8000/api/user");

      if (data) {
        sessionStorage.setItem("verified", true);
      }
      return data;
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
}
