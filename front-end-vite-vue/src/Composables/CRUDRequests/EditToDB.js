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
  try {
    if (button) button.disabled = true;

    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    const response = await axios.post(endpoint + id, formElements);

    if (response && response.data) {
      store.commit("setMessage", response.data.message);
      store.commit("setIconColor", response.data.iconColor);
    }

    if (errors) errors.value = null;
    if (button) button.disabled = false;
    if (redirectTo) router.push({ name: redirectTo });

    return true;
  } catch (error) {
    if (button) button.disabled = false;

    if (error.response) {
      if (error.response.status === 422) {
        if (errors) errors.value = error.response.data.errors;
        console.log(errors && errors.value);
      } else if (
        error.response.status === 401 ||
        error.response.status === 403
      ) {
        removeCredentials();
      } else {
        store.commit("setError", error);
      }
    } else {
      console.error("An unexpected error occurred:", error);
    }

    return false;
  }
};

export default EditToDB;
