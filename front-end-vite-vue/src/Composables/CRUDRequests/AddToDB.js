import axios from "axios";
import store from "@/store";
import router from "@/router";

const AddToDB = async (button, endpoint, formElements, redirectTo, errors) => {
  button.disabled = true;
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    // Send the FormData object to the server using axios
    await axios.post(endpoint, formElements).then((response) => {
      store.commit("setMessage", response.data.message);
    });
    errors.value = null;
    if (redirectTo != "") router.push({ name: redirectTo });
    return true;
  } catch (error) {
    button.disabled = false;
    if (error.response.status == 422) {
      errors.value = error.response.data.errors;
    } else if (error) {
      // verifying if the error is that of login
      if (error.response.status == 401 || error.response.status == 403) {
        removeCredentials();
      } else store.commit("setError", error);
    }
    return false;
  }
};

export default AddToDB;
