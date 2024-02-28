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
      state.authentication = localStorage.getItem("Authentication") ?? false;
    },
    setUser(state) {
      state.user = JSON.parse(localStorage.getItem("User")) ?? null;
    },
  },
  actions: {},
  modules: {},
});
