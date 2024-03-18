import Swal from "sweetalert2";
import axios from "axios";

const logout = async (store, route, router) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/logout").then((response) => {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    });
    if (route.meta.requiresAuth) {
      router.push({ name: "home" });
    }
    // taking out the user from storage/store
    localStorage.removeItem("Authentication");
    localStorage.removeItem("User");
    localStorage.removeItem("authMessage");
    store.commit("setAuthentication");
    store.commit("setUser");
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error.message,
    });
    localStorage.removeItem("Authentication");
    localStorage.removeItem("User");
    localStorage.removeItem("authMessage");
    store.commit("setAuthentication");
    store.commit("setUser");
  }
};
export default logout;
