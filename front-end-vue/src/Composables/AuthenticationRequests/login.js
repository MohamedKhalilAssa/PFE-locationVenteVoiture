import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";

const login = async (button, form, router, route, store, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios
      .post(Endpoints.login, {
        email: form.value.email,
        password: form.value.password,
      })
      .then((response) => {
        store.commit("setMessage", response.data.message);
      });

    let { data } = await axios.get(Endpoints.getAuthenticatedUser);

    // storing the data
    localStorage.setItem("Authentication", true);
    localStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

    if (data.role == "admin" || data.role == "root") {
      router.push({
        name: `adminHome`,
      });
    } else {
      router.push({
        name: `${route.query.previous}`,
      });
    }
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

export default login;
