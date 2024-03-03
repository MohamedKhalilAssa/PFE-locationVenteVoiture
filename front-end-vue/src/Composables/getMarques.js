import axios from "axios";
import { ref } from "vue";
const getMarques = () => {
  const marqueResult = ref([]);
  const Error = ref(null);

  const load = async (count = 0) => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get("http://localhost:8000/api/marque");
      marqueResult.value = data;
    } catch (error) {
      if (error) {
        Error.value = error.message;
      }
    }
  };
  return { marqueResult, Error, load };
};
export default getMarques;
