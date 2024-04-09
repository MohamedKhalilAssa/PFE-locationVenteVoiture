import axios from "axios";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
import store from "@/store";

const getPaginate = async (
  page = 1,
  endpoint,
  sort = "",
  sortColumn = "",
  search = "",
  searchColumn = "",
  defaultColumn = ""
) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    searchColumn = searchColumn ? searchColumn : defaultColumn;
    sortColumn = sortColumn ? sortColumn : "id";
    let result = await axios.get(
      endpoint +
        page +
        "&sort=" +
        sort +
        "&sortColumn=" +
        sortColumn +
        "&search=" +
        search +
        "&searchColumn=" +
        searchColumn +
        "&defaultColumn=" +
        defaultColumn
    );
    if (result.statusText == "OK") {
      return result.data;
    } else {
      return "Error " + result.statusText + "\n" + result.data.message;
    }
  } catch (error) {
    if (error) {
      // verifying if the error is that of login
      if (error.response.status == 401 || error.response.status == 403) {
        removeCredentials();
        window.location.reload();
      } else store.commit("setError", error);
    }
  }
};
export default getPaginate;
