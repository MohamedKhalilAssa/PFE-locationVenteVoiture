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
  try {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;

    // making sure that all params are sent
    searchSortParams.searchColumn =
      searchSortParams.searchColumn || searchSortParams.defaultColumn;
    searchSortParams.sortColumn = searchSortParams.sortColumn || "id";

    // Convert params objects into query strings
    const sortSearch = Object.entries(searchSortParams)
      .map(
        ([key, value]) =>
          `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
      )
      .join("&");
    let filtersQuery;
    if (typeof filters === "string") {
      filtersQuery = filters;
    } else {
      filtersQuery = Object.entries(filters)
        .map(
          ([key, value]) =>
            `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
        )
        .join("&");
    }

    // Make the request
    const result = await axios.get(
      endpoint + page + "&" + sortSearch + "&" + filtersQuery
    );

    if (result.status === 200) {
      return result.data;
    } else {
      return "Error " + result.status + "\n" + result.data.message;
    }
  } catch (error) {
    if (error.response) {
      if (error.response.status === 401 || error.response.status === 403) {
        removeCredentials();
        window.location.reload();
      } else {
        store.commit("setError", error);
      }
    } else {
      console.error("An unexpected error occurred:", error);
    }
  }
};
export default getPaginate;
