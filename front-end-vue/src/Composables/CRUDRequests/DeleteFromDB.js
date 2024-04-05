import axios from "axios";
import Swal from "sweetalert2";

const DeleteFromDB = async (
  endpoint,
  id,
  loadingFunction,
  getter,
  currentPage,
  resultHolder,
  totalHolder,
  store
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
      // Send a delete request to the server
      axios.defaults.withCredentials = true;
      axios.defaults.withXSRFToken = true;
      try {
        // Send the FormData object to the server using axios
        await axios.delete(endpoint + id).then((response) => {
          store.commit("setMessage", response.data.message);
          store.commit("setIconColor", response.data.iconColor);
        });
        loadingFunction(currentPage, getter).then((data) => {
          if (data.PaginateQuery.data.length == 0) {
            loadingFunction(currentPage - 1, getter).then((data) => {
              resultHolder.value = data.PaginateQuery;
              totalHolder.value = data.total;
            });
          } else {
            resultHolder.value = data.PaginateQuery;
            totalHolder.value = data.total;
          }
        });
      } catch (error) {
        if (error) {
          // verifying if the error is that of login 
          if (error.response.status == 401 || error.response.status == 403) {
            removeCredentials();
          } else
            store.commit("setError", error);
        }
      }
    }
  });
};

export default DeleteFromDB;
