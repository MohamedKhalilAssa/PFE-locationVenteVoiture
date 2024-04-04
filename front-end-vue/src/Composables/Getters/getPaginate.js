import axios from "axios";
import { ref } from "vue";

const getPaginate = async (page = 1, endpoint, store, sort = '', sortColumn = "", search = "", searchColumn = '', defaultColumn = "") => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    searchColumn = searchColumn ? searchColumn : defaultColumn;
    sortColumn = sortColumn ? sortColumn : 'id';
    let result = await axios.get(endpoint + page + "&sort=" + sort + "&sortColumn=" + sortColumn + "&search=" + search + "&searchColumn=" + searchColumn + "&defaultColumn=" + defaultColumn);
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
