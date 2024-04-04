import axios from "axios";
import { ref } from "vue";

const getPaginate = async (page = 1, endpoint, search = "",selectedColumn=null, store) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    let result = await axios.get(endpoint + page + "&search=" + search+ "&selectedColumn=" + selectedColumn);

    if (result.statusText == "OK") {
      return result.data;
    } else {
      return "Error " + result.statusText + "\n" + result.data.message;
    }
  } catch (error) {
    if (error) {
      store.commit("setError", error);
    }
  }
};
export default getPaginate;
