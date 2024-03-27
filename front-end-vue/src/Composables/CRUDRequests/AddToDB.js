import axios from "axios";

const AddToDB = async (
  button,
  endpoint,
  formElements,
  router,
  store,
  redirectTo,
  errors
) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    // Send the FormData object to the server using axios
    await axios.post(endpoint, formElements).then((response) => {
      store.commit("setMessage", response.data.message);
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

export default AddToDB;
