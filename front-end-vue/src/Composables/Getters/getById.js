import axios from "axios";
import { ref } from "vue";

const getById = async (endpoint, id, serverError) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    let result = await axios.get(endpoint + id);
    if (result.statusText == "OK") {
      return result.data;
    } else {
      return "Error " + result.statusText + "\n" + result.data.message;
    }
  } catch (error) {
    if (error) {
      serverError = error.response.data.message;
    }
  }
};
export default getById;
