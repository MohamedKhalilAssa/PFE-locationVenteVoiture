import axios from "axios";

const EditToDB = async (
  button,
  endpoint,
  id,
  formElements,
  router,
  store,
  redirectTo,
  errors,
  serverError
) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    // Send the FormData object to the server using axios
    await axios.post(endpoint + id, formElements).then((response) => {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    });

    router.push({ name: redirectTo });
  } catch (error) {
    button.disabled = false;
    if (error.response.status == 422) errors.value = error.response.data.errors;
    else if (error) {
      store.commit("setError", error);
    }
  }
};

export default EditToDB;
