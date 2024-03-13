import axios from "axios";

export default async function VerifyAuth(store) {
  if (
    !sessionStorage.getItem("verified") &&
    localStorage.getItem("Authentication")
  ) {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      const { data } = await axios.get("http://localhost:8000/api/user");

      sessionStorage.setItem("verified", true);
      return data;
    } catch (error) {
      localStorage.removeItem("Authentication");
      localStorage.removeItem("User");
      localStorage.removeItem("authMessage");
      store.commit("setAuthentication");
      store.commit("setUser");
      let previous = to.name;
      next({ name: "Login", query: { previous: previous } });
    }
  }
}
