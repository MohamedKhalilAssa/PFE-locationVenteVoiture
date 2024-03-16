import axios from "axios";
import { ref } from "vue";
const getModeleById = () => {
  const modelesResult = ref({});
  const ErrorModele = ref(null);

  const loadModele = async (id) => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get("http://localhost:8000/api/modele/" + id);
      modelesResult.value = data;
    } catch (error) {
      if (error) {
        ErrorModele.value = error.message;
      }
    }
  };
  return { modelesResult, ErrorModele, loadModele };
};
export default getModeleById;
