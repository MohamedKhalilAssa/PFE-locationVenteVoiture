import axios from "axios";

const register = async (button, form, router, store, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/register", {
      nom: form.value.nom,
      prenom: form.value.prenom,
      telephone: form.value.telephone,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.password_confirmation,
    });

    let { data } = await axios.get("http://localhost:8000/api/user");
    localStorage.setItem("Authentication", true);
    localStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

    router.push({ name: "home", query: { message: "loggedIn" } });
  } catch (error) {
    button.disabled = false;
    if (error.response.status == 404 || error.response.status == 500) {
      store.commit("setError", error);
    }
    if (error.response) {
      errors.value = error.response.data.errors ?? null;
    }
  }
};

export default register;
