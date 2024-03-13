import Swal from "sweetalert2";
import axios from "axios";

const logout = async (store, route, router) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/logout");
    if (route.meta.requiresAuth) {
      router.push({ name: "home", query: { message: "loggedOut" } });
    }
    // taking out the user from storage/store
    Cookies.remove("Authentication");
    Cookies.remove("User");
    Cookies.remove("authMessage");
    store.commit("setAuthentication");
    store.commit("setUser");

    // Show succes message
    const Toast = Swal.mixin({
      toast: true,
      position: "bottom-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
    Toast.fire({
      icon: "success",
      iconColor: "red",
      title: "Déconnecté avec succès",
    });
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: error.message,
    });
    Cookies.remove("Authentication");
    Cookies.remove("User");
    Cookies.remove("authMessage");
  }
};
export default logout;
