import { createRouter, createWebHistory } from "vue-router";
import store from "@/store"; // Import the Vuex store
import axios from "axios";
import Endpoints from "@/assets/JS/Endpoints";
import removeCredentials from "@/Composables/AuthenticationRequests/removeCredentials";
// subfiles
import AdminRoutes from "@/router/AdminRoutes/index";
import authenticationRoutes from "@/router/GlobalRoutes/authenticationRoutes";

const routes = [
  {
    path: "/",
    name: "home",
    component: () => import("@/views/FrontOffice/HomeView.vue"),
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
  // Authentication routes
  ...authenticationRoutes,
  {
    path: "/admin",
    children: [
      {
        path: "",
        name: "adminHome",
        component: () =>
          import("@/views/BackOffice/AdminViews/DashboardView.vue"),
        meta: { requiresAuth: true, requiresAdmin: true },
      },
      ...AdminRoutes,
      // { path: "users/:id", component: AdminUserDetails },
    ],
  },
  {
    path: "/:catchAll(.*)",
    name: "NotFound",
    component: () => import("@/views/PageNotFound.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from, next) => {
  if (
    to.meta.requiresGuest &&
    (localStorage.getItem("Authentication") || localStorage.getItem("User"))
  ) {
    next(from);
  } else if (
    to.meta.requiresAuth &&
    (!localStorage.getItem("Authentication") || !localStorage.getItem("User"))
  ) {
    // if not authenticated remove the localStorage just in case
    removeCredentials();
    // send back
    let previous = to.name;
    next({ name: "Login", query: { previous: previous } });
    //initial check for token
  } else if (
    to.meta.requiresAuth &&
    localStorage.getItem("Authentication") &&
    !sessionStorage.getItem("verified")
  ) {
    // to check the token authenticity
    axios.defaults.withCredentials = true;
    axios.defaults.withXSRFToken = true;
    try {
      const { data } = await axios.get(
        Endpoints.config__get_authenticated_user
      );

      if (data) {
        if (!to.meta.requiresAdmin) {
          next();
        } else if (
          (data.role == "admin" || data.role == "root") &&
          to.meta.requiresAdmin
        ) {
          next();
        } else {
          store.commit(
            "setError",
            "Vous n'avez pas les droits pour accéder à cette page"
          );
          store.commit("setErrorCode", 403);
          next({ name: "home" });
        }
      }
    } catch (error) {
      removeCredentials();
      let previous = to.name;
      next({ name: "Login", query: { previous: previous } });
    }
  } else {
    next();
  }
});

export default router;
