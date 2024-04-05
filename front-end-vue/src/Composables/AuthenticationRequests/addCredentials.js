// adding the info to localStorage

import store from "@/store";

const addCredentials = (data) => {
    // taking out the user from storage/store
    localStorage.setItem("Authentication", true);
    localStorage.setItem("User", JSON.stringify(data));
    store.commit("setAuthentication");
    store.commit("setUser");

};

export default addCredentials;
