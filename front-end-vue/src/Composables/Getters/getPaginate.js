import axios from "axios";
import { ref } from "vue";

const getPaginate = async (page = 1, endpoint, serverError) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    //   "http://localhost:8000/api/modele/pagination?page=";
    let { data } = await axios.get(endpoint + page);
    return data;
  } catch (error) {
    if (error) {
      serverError = error.response.data.message;
    }
  }
};
export default getPaginate;
