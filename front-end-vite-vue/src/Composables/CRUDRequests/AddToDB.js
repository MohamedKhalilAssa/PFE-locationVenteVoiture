import axios from "axios";
import store from "@/store";
import router from "@/router";

const AddToDB = async (button, endpoint, formElements, redirectTo, errors) => {
  try {
    if (button) button.disabled = true;

    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    const response = await axios.post(endpoint, formElements);

    if (response && response.data) {
      store.commit("setMessage", response.data.message);
    }

    if (errors) errors.value = null;
    if (redirectTo) router.push({ name: redirectTo });

    return true;
  } catch (error) {
    if (button) button.disabled = false;

    if (error.response) {
      if (error.response.status === 422) {
        if (errors) errors.value = error.response.data.errors;
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

export default AddToDB;
