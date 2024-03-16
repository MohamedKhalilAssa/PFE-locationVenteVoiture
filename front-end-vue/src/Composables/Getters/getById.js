import axios from "axios";
import { ref } from "vue";

const getById = async (endpoint, id, serverError) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    let { data } = await axios.get(endpoint + id);
    return data;
  } catch (error) {
    serverError = error.response.data.message;
  }
};
export default getById;
