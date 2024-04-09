import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import addCredentials from "@/Composables/AuthenticationRequests/addCredentials";
import router from "@/router";
import store from "@/store";

const login = async (button, form, route, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios
      .post(Endpoints.config__login, {
        email: form.value.email,
        password: form.value.password,
      })
      .then((response) => {
        store.commit("setMessage", response.data.message);
      });

    let { data } = await axios.get(Endpoints.config__get_authenticated_user);

    // storing the data
    addCredentials(data);

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
