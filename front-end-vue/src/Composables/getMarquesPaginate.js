import axios from "axios";
import { ref } from "vue";
const getMarquesPaginate = () => {
  const marqueResult = ref([]);
  const ErrorMarque = ref(null);

  const loadMarque = async (page = 1) => {
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");
      let { data } = await axios.get(
        "http://localhost:8000/api/marque/pagination?page=" + page
      );
      marqueResult.value = data;
    } catch (error) {
      if (error) {
        ErrorMarque.value = error.message;
      }
    }
  };
  return { marqueResult, ErrorMarque, loadMarque };
};
export default getMarquesPaginate;
