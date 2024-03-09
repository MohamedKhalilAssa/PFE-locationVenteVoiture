import Swal from "sweetalert2";

function successLoggedInMessage(message, store) {
  if (
    message &&
    message === "loggedIn" &&
    !sessionStorage.getItem("authMessage")
  ) {
    if (store.getters.getAuthentication) {
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
      sessionStorage.setItem("authMessage", true);
    }
  }
}
export default successLoggedInMessage;
