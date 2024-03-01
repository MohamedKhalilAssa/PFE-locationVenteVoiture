import axios from "axios";
const serverError = ref(null);
const result = ref([]);
const getMarques = async () => {
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    result.value = await axios.get("http://localhost:8000/api/marque");

    // storing the data

    return result, serverError;
  } catch (error) {
    if (error.response.status == 404 || error.response.status == 500) {
      serverError.value = error.message;
    }
  }
};

export default getMarques;
