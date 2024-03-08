import axios from "axios";
import { ref } from "vue";
const getVilles = () => {
  const villeResult = ref([]);
  const ErrorVille = ref(null);

  const loadVille = async () => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get("http://localhost:8000/api/ville");
      villeResult.value = data;
    } catch (error) {
      if (error) {
        ErrorVille.value = error.message;
      }
    }
  };
  return { villeResult, ErrorVille, loadVille };
};
export default getVilles;
