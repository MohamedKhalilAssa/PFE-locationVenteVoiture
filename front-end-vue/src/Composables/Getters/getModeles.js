import axios from "axios";
import { ref } from "vue";
const getModeles = () => {
  const modelesResult = ref([]);
  const Error = ref(null);

  const loadModele = async (marque_id) => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get(
        "http://localhost:8000/api/modele/marque/" + marque_id
      );
      modelesResult.value = data;
    } catch (error) {
      if (error) {
        Error.value = error.message;
      }
    }
  };
  return { modelesResult, Error, loadModele };
};
export default getModeles;
