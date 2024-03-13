import axios from "axios";
import { ref } from "vue";
const getCouleurs = () => {
  const couleurResult = ref([]);
  const ErrorCouleur = ref(null);

  const loadCouleur = async () => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get("http://localhost:8000/api/couleur");
      couleurResult.value = data;
    } catch (error) {
      if (error) {
        ErrorCouleur.value = error.message;
      }
    }
  };
  return { couleurResult, ErrorCouleur, loadCouleur };
};
export default getCouleurs;
