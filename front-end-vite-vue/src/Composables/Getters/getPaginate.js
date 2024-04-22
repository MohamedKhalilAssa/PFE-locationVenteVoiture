import axios from "axios";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
import store from "@/store";

/**
 * searchSortParams = {searchColumn: "", sortColumn: "", search: "", sort: "",defaultColumn} contain params
 * necessary for basic sorting
 *
 * filters = {column: "value", ....  } will help for something that is specific
 */

const getPaginate = async (
  page = 1,
  endpoint,
  searchSortParams = {},
  filters = {}
) => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  // Convert formData object to a query string

  try {
    // default case handling
    searchSortParams.searchColumn = searchSortParams.searchColumn
      ? searchSortParams.searchColumn
      : searchSortParams.defaultColumn;
    searchSortParams.sortColumn = searchSortParams.sortColumn
      ? searchSortParams.sortColumn
      : "id";

    // turning params object into query string
    const sortSearch = Object.keys(searchSortParams)
      .map(
        (key) =>
          `${encodeURIComponent(key)}=${encodeURIComponent(
            searchSortParams[key]
          )}`
      )
      .join("&");
    const filtersQuery = Object.keys(filters)
      .map(
        (key) =>
          `${encodeURIComponent(key)}=${encodeURIComponent(filters[key])}`
      )
      .join("&");
    console.log(filtersQuery);
    let result = await axios.get(
      endpoint + page + "&" + sortSearch + "&" + filtersQuery
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
