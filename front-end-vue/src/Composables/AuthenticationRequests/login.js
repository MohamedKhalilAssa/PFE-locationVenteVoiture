import axios from "axios";

const login = async (
  button,
  form,
  router,
  route,
  store,
  errors,
  serverError
) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios
      .post("http://localhost:8000/login", {
        email: form.value.email,
        password: form.value.password,
      })
      .then((response) => {
        store.commit("setMessage", response.data.message);
      });

    let { data } = await axios.get("http://localhost:8000/api/user");

    // storing the data
    localStorage.setItem("Authentication", true);
    localStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

    if (data.role == "admin") {
      router.push({
        name: `DashboardView`,
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
        serverError.value = "Too many requests. Please try again later.";
        setTimeout(() => {
          serverError.value = null;
        }, 5000);
      } else if (error.response.status != 422) {
        serverError.value = error.message;
        setTimeout(() => {
          serverError.value = null;
        }, 5000);
      } else {
        errors.value = error.response.data.errors ?? null;
      }
    }
  }
};

export default login;
