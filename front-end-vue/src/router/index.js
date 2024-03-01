import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import PageNotFound from "../views/PageNotFound.vue";
import axios from "axios";
import { useStore } from "vuex";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/neuf",
    name: "neuf",
    component: () => import("../views/Neuf/NeufListingsView.vue"),
  },
  {
    path: "/occasion",
    name: "occasion",
    component: () => import("../views/Occasion/OccasionListingsView.vue"),
  },
  {
    path: "/location",
    name: "location",
    component: () => import("../views/Location/LocationListingsView.vue"),
  },
  {
    path: "/annonce",
    name: "annonce",
    component: () => import("../views/AnnonceView.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("../views/Users/RegisterView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("../views/Users/LoginView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/:catchAll(.*)",
    name: "NotFound",
    component: PageNotFound,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresGuest && localStorage.getItem("Authentication")) {
    next({ name: "home" });
  } else if (to.meta.requiresAuth && !localStorage.getItem("Authentication")) {
    //initial check for token
    next({ name: "Login" });
  } else if (to.meta.requiresAuth && localStorage.getItem("Authentication")) {
    // to check the token authenticity
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    const store = useStore();
    axios
      .get("http://localhost:8000/api/user")
      .then((response) => {
        next();
      })
      .catch((error) => {
        localStorage.removeItem("Authentication");
        localStorage.removeItem("User");
        store.commit("setAuthentication");
        store.commit("setUser");
        next({ name: "Login" });
      });
  } else {
    next();
  }
});

export default router;
