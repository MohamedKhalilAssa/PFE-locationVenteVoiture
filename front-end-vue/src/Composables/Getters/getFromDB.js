import axios from "axios";
import { ref } from "vue";

const getFromDB = async (endpoint) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    let result = await axios.get(endpoint);
    if (result.statusText == "OK") {
      return result.data;
    } else {
      return "Error " + result.statusText + "\n" + result.data.message;
    }
  } catch (error) {
    if (error) {
      ErrorCouleur.value = error.message;
    }
  }
};
export default getFromDB;
