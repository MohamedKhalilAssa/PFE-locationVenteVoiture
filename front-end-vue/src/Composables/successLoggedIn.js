import Swal from "sweetalert2";

export default function successLoggedInMessage(message) {
  if (message && message === "loggedIn") {
    const Toast = Swal.mixin({
      toast: true,
      position: "bottom-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
    Toast.fire({
      icon: "success",
      title: "Connecté avec succès",
    });
  }
}
