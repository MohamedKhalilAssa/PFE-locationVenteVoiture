import { createStore } from "vuex";

export default createStore({
  state: {
    authentication: false,
    user: null,
  },
  getters: {
    getAuthentication(state) {
      return state.authentication;
    },
    getUser(state) {
      return state.user;
    },
  },
  mutations: {
    setAuthentication(state) {
      state.authentication = sessionStorage.getItem("Authentication") ?? false;
    },
    setUser(state) {
      state.user = JSON.parse(sessionStorage.getItem("User")) ?? null;
    },
  },
  actions: {},
  modules: {},
});
