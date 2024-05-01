import Endpoints from "@/assets/JS/Endpoints";
import EditToDB from "../CRUDRequests/EditToDB";
import Swal from "sweetalert2";
import vente from "@/Composables/Custom/vente";
import location from "@/Composables/Custom/location";

const changeDisponibility = async (row, key, value, type) => {
  await Swal.fire({
    title: "Change disponibilite",
    text: "Are you sure? You won't be able to revert this!",
    html: `<select id="dispoChange"  class="mx-auto block w-1/2 rounded-md border p-2 border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <option ${
          row[key] === "disponible" ? "selected" : ""
        } value="disponible">Disponible</option>
        <option  ${
          row[key] === "indisponible" ? "selected" : ""
        } value="indisponible">Indisponible</option>
        <option  ${
          row[key] === "vendu" || row[key] === "louer" ? "selected" : ""
        } value="${value}">${value}</option>
      </select>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, change it!",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const disponibilite = document.querySelector("#dispoChange").value;
      const form = new FormData();
      form.append("disponibilite_" + type, disponibilite);
      if (type === "location") {
        let returnVal = await location();
        if (!returnVal) {
          return false;
        }
      }
      await EditToDB(
        null,
        Endpoints.annonce__update_disponibilite,
        row.id,
        form,
        ""
      );
    }
  });
};
export default changeDisponibility;
