import axios from "axios";
import store from "@/store";
import router from "@/router";

const EditToDB = async (
  button,
  endpoint,
  id,
  formElements,
  redirectTo,
  errors
) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    // Send the FormData object to the server using axios
    await axios.post(endpoint + id, formElements).then((response) => {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    });

    router.push({ name: redirectTo });
  } catch (error) {
    button.disabled = false;
    if (error.response.status == 422) {
      errors.value = error.response.data.errors;
      console.log(errors.value);
    } else if (error) {
      // verifying if the error is that of login
      if (error.response.status == 401 || error.response.status == 403) {
        removeCredentials();
      } else store.commit("setError", error);
    }
  }
};

export default EditToDB;
