import Endpoints from "@/assets/JS/Endpoints";
import axios from "axios";

const register = async (button, form, router, store, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios
      .post(Endpoints.register, {
        nom: form.value.nom,
        prenom: form.value.prenom,
        telephone: form.value.telephone,
        email: form.value.email,
        password: form.value.password,
        password_confirmation: form.value.password_confirmation,
      })
      .then((response) => {
        store.commit("setMessage", response.data.message);
      });

    let { data } = await axios.get(Endpoints.getAuthenticatedUser);
    localStorage.setItem("Authentication", true);
    localStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

    router.push({ name: "home", query: { message: "loggedIn" } });
  } catch (error) {
    button.disabled = false;
    if (error.response) {
      if (error.response.status == 429) {
        store.commit("setError", "Too many requests. Please try again later.");
      } else if (error.response.status != 422) {
        store.commit("setError", error);
      } else {
        errors.value = error.response.data.errors ?? null;
      }
    }
  }
};

export default register;
