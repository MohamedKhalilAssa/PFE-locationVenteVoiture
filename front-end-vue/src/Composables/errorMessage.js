import Swal from "sweetalert2";

function unauthorizedMessage(error) {
  if (error && !sessionStorage.getItem("errorMessage")) {
    setTimeout(() => {
      Swal.fire({
        title: error,
        text: "Veuillez suivre les instructions, ou contacter l'administrateur pour plus d'informations",
        icon: "error",
      });
      sessionStorage.setItem("errorMessage", true);
    }, 2800);
  }
}
export default unauthorizedMessage;
