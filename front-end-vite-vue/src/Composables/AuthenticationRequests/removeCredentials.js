import store from "@/store";
import getCSRFToken from "../Getters/getCSRFToken";

const removeCredentials = () => {
    // taking out the user from storage/store
    localStorage.removeItem("Authentication");
    localStorage.removeItem("User");
    sessionStorage.removeItem("verified");
    store.commit("setAuthentication");
    store.commit("setUser");
    getCSRFToken(store);
};

export default removeCredentials;
