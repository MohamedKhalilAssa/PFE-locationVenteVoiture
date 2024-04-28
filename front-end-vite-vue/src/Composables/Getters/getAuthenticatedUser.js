import axios from "axios";
import store from "@/store";
import Endpoints from "@/assets/JS/Endpoints";

const getAuthenticatedUser = async () => {
  try {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    let result = await axios.get(Endpoints.config__get_authenticated_user);
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
export default getAuthenticatedUser;
