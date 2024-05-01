import Endpoints from "@/assets/JS/Endpoints";
import EditToDB from "../CRUDRequests/EditToDB";
import Swal from "sweetalert2";

const location = async (row, key) => {
  let returnVal = await Swal.fire({
    title: "Location Information",
    html: `<input id="date_debut" type="datetime-local" min="${
      new Date().toISOString().split("T")[0]
    }" class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Save!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const date_debut = document.querySelector("#date_debut").value;
      const form = new FormData();
      console.log(date_debut);
      form.append("date_debut", date_debut);
      //   EditToDB(null, Endpoints.annonce__update_status, row.id, form, "");
      return true;
    } else {
      return false;
    }
  });
  return returnVal;
};
export default location;
