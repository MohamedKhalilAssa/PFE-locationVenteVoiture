import axios from "axios";
import { ref } from "vue";
const getMarques = () => {
  const marqueResult = ref([]);
  const ErrorMarque = ref(null);

  const loadMarque = async () => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get("http://localhost:8000/api/marque");
      marqueResult.value = data;
    } catch (error) {
      if (error) {
        ErrorMarque.value = error.message;
      }
    }
  };
  return { marqueResult, ErrorMarque, loadMarque };
};
export default getMarques;
