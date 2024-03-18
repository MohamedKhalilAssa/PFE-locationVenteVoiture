import axios from "axios";
import Swal from "sweetalert2";

const DeleteFromDB = async (
  endpoint,
  id,
  loadingFunction,
  getter,
  resultHolder,
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
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        // Send the FormData object to the server using axios
        await axios.delete(endpoint + id).then((response) => {
          store.commit("setMessage", response.data.message);
          store.commit("setIconColor", response.data.iconColor);
        });
        loadingFunction(1, getter).then((data) => {
          resultHolder.value = data;
        });
      } catch (error) {
        Swal.fire({
          title: "Error!",
          text: "Failed to delete the marque.",
          icon: "error",
        });
      }
    }
  });
};

export default DeleteFromDB;
