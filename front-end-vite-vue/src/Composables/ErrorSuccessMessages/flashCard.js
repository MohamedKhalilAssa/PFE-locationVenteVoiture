import Swal from "sweetalert2";

const flashCard = async (message, iconColor = "green") => {
  if (message) {
    const Toast = Swal.mixin({
      toast: true,
      position: "bottom-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
    Toast.fire({
      icon: "success",
      iconColor: iconColor,
      title: message,
    });
  }
};
export default flashCard;
