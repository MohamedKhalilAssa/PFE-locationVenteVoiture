import Swal from "sweetalert2";

const errorFlashCard = async (error, code = "") => {
  if (error && error.response) {
    Swal.fire({
      title: "Error " + error.response.status + "!",
      text: error.response.data.message,
      icon: "error",
    });
  } else if (error) {
    Swal.fire({
      title: "Error " + code + "!",
      text: error,
      icon: "error",
    });
  }
};
export default errorFlashCard;
