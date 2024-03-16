import axios from "axios";
import { ref } from "vue";
const getModelesPaginate = () => {
  const modeleResult = ref([]);
  const ErrorModele = ref(null);

  const loadModele = async (page = 1) => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get(
        "http://localhost:8000/api/modele/pagination?page=" + page
      );
      modeleResult.value = data;
    } catch (error) {
      if (error) {
        ErrorModele.value = error.message;
      }
    }
  };
  return { modeleResult, ErrorModele, loadModele };
};
export default getModelesPaginate;
