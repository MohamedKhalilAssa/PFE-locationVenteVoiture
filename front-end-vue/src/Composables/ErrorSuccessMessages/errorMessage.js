import Swal from "sweetalert2";

function errorMessage(error) {
  if (error) {
    Swal.fire({
      title: error,
      text: "Veuillez suivre les instructions, ou contacter l'administrateur pour plus d'informations",
      icon: "error",
    });
  }
}
export default errorMessage;
