import { createStore } from "vuex";

export default createStore({
  state: {
    authentication: false,
    user: null,
    message: null,
    error: null,
    errorCode: null,
    iconColor: "green",
  },
  getters: {
    getAuthentication(state) {
      return state.authentication;
    },
    getUser(state) {
      return state.user;
    },
    getFullName(state) {
      if (state.user == null) return null;
      return state.user.nom + " " + state.user.prenom;
    },
    getMessage(state) {
      return state.message;
    },
    getIconColor(state) {
      return state.iconColor;
    },
    getError(state) {
      return state.error;
    },
    getErrorCode(state) {
      return state.errorCode;
    },
  },
  mutations: {
    setAuthentication(state) {
      state.authentication = localStorage.getItem("Authentication") ?? false;
    },
    setUser(state) {
      state.user = JSON.parse(localStorage.getItem("User")) ?? null;
    },
    setMessage(state, message) {
      state.message = message;
    },
    setIconColor(state, iconColor) {
      state.iconColor = iconColor;
    },
    setError(state, error) {
      state.error = error;
    },
    setErrorCode(state, errorCode) {
      state.errorCode = errorCode;
    },
  },
  actions: {},
  modules: {},
});
