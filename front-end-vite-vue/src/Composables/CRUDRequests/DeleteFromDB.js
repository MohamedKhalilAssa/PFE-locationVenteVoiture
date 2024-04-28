import axios from "axios";
import Swal from "sweetalert2";
import store from "@/store";

const DeleteFromDB = async (
  endpoint,
  id,
  loadingFunction,
  getter,
  currentPage,
  resultHolder,
  totalHolder
) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        // Send a delete request to the server
        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;

        const response = await axios.delete(endpoint + id);

        if (response && response.data) {
          store.commit("setMessage", response.data.message);
          store.commit("setIconColor", response.data.iconColor);
        }

        const data = await loadingFunction(currentPage, getter);

        if (data.PaginateQuery.data.length === 0) {
          const newData = await loadingFunction(currentPage - 1, getter);
          resultHolder.value = newData.PaginateQuery;
          totalHolder.value = newData.total;
        } else {
          resultHolder.value = data.PaginateQuery;
          totalHolder.value = data.total;
        }
      } catch (error) {
        if (error.response) {
          if (error.response.status === 401 || error.response.status === 403) {
            removeCredentials();
          } else {
            store.commit("setError", error);
          }
        } else {
          console.error("An unexpected error occurred:", error);
        }
      }
    }
  });
};

export default DeleteFromDB;
