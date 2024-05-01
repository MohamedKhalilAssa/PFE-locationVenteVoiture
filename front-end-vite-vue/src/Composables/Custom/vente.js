import Endpoints from "@/assets/JS/Endpoints";
import EditToDB from "../CRUDRequests/EditToDB";
import Swal from "sweetalert2";

const changeStatus = async (row, key) => {
  await Swal.fire({
    title: "Change status",
    html: `<select id="statusChange"  class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option ${
      row[key] === "onhold" ? "selected" : ""
    } value="onhold">On Hold</option>
    <option  ${
      row[key] === "approved" ? "selected" : ""
    } value="approved">Approved</option>
    <option  ${
      row[key] === "disabled" ? "selected" : ""
    } value="disabled">Disabled</option>
  </select>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, change it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const status = document.querySelector("#statusChange").value;
      const form = new FormData();
      form.append("statut_annonce", status);
      EditToDB(null, Endpoints.annonce__update_status, row.id, form, "");
    }
  });
};
export default changeStatus;
