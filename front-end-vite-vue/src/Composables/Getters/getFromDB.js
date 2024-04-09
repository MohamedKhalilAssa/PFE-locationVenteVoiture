import axios from "axios";
import store from "@/store";

const getFromDB = async (endpoint) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    let result = await axios.get(endpoint);
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
export default getFromDB;
