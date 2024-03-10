import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/FrontOffice/HomeView.vue";
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
    component: () => import("../views/FrontOffice/Neuf/NeufListingsView.vue"),
  },
  {
    path: "/occasion",
    name: "occasion",
    component: () =>
      import("../views/FrontOffice/Occasion/OccasionListingsView.vue"),
  },
  {
    path: "/location",
    name: "location",
    component: () =>
      import("../views/FrontOffice/Location/LocationListingsView.vue"),
  },
  {
    path: "/annonce",
    name: "annonce",
    component: () =>
      import("../views/FrontOffice/Annonces/CreateAnnonceView.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("../views/FrontOffice/Users/RegisterView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("../views/FrontOffice/Users/LoginView.vue"),
    meta: { requiresGuest: true },
  },
  {
    path: "/admin",
    children: [
      {
        path: "",
        name: "DashboardView",
        component: () =>
          import("../views/BackOffice/AdminViews/DashboardView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      // { path: "users", component: AdminUserList },
      // { path: "users/:id", component: AdminUserDetails },
    ],
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

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresGuest && sessionStorage.getItem("Authentication")) {
    next(from);
  } else if (
    to.meta.requiresAuth &&
    !sessionStorage.getItem("Authentication")
  ) {
    //initial check for token
    let previous = to.name;
    next({ name: "Login", query: { previous: previous } });
  } else if (to.meta.requiresAuth && sessionStorage.getItem("Authentication")) {
    // to check the token authenticity
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    const store = useStore();
    try {
      const { data } = await axios.get("http://localhost:8000/api/user");

      console.log(data);
      if (data) {
        if (!to.meta.requiresAdmin) {
          next();
        } else if (data.role == "admin" && to.meta.requiresAdmin) {
          next();
        } else {
          next({ name: "home", query: { error: "unAuthorized" } });
        }
      }
    } catch (error) {
      sessionStorage.removeItem("Authentication");
      sessionStorage.removeItem("User");
      store.commit("setAuthentication");
      store.commit("setUser");
      let previous = to.name;
      next({ name: "Login", query: { previous: previous } });
    }
  } else {
    next();
  }
});

export default router;
