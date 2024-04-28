import axios from "axios";
import store from "@/store";

const getById = async (endpoint, id) => {
  try {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    let result = await axios.get(endpoint + id);
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
export default getById;
